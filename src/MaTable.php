<?php

namespace Paquix\Ma;

use Paquix\Ma\CsvParser;

class MaTable
{	
	const ROWS_PER_PAGE = 15;
	const RANGE = [
		'DAY' => 1,
		'WEEK' => 7,
		'MONTH' => 30,
	];
	
	private $rows = [];
	private $nextPage;
	private $prevPage;
	
	public function __construct(string $range)
	{
		$this->import();
		$this->convertToTime();
		$this->sortByDate(SORT_ASC);
		$this->convertToDate();
		$this->groupByDate();
		$this->calc($range);
	}
	
	public function paginate($page) 
	{
		if ($page == null)
			$page = 1;
		
		$offset = $page * self::ROWS_PER_PAGE - self::ROWS_PER_PAGE;
		$rows = array_slice($this->rows, $offset, self::ROWS_PER_PAGE);
		$this->rows = $rows;
		
		if (count($rows) < self::ROWS_PER_PAGE)
			$this->nextPage = null;
		else
			$this->nextPage = $page + 1;
		
		if ($page == 1)
			$this->prevPage = null;
		else
			$this->prevPage = $page - 1;
	}
	
	public function getRows() 
	{
		return $this->rows;
	}
	
	public function getNextPage() 
	{
		return $this->nextPage;
	}
	
	public function getPrevPage() 
	{
		return $this->prevPage;
	}
	
	private function import() 
	{
		$csvFile = Config::get('WEATHER_STATS_FILE');
		$parser = new CsvParser($csvFile, ';', true, [
			0 => 'date',
			1 => 'origValue',
		]);

		$this->rows = $parser->getParsedRows();
	}
	
	private function convertToTime() 
	{
		foreach ($this->rows as $key => $value) {
			$this->rows[$key]['date'] = strtotime($value['date']);
		}
	}
	
	private function sortByDate($order) 
	{
		$date = array_column($this->rows, 'date');
		array_multisort($this->rows, $order, $date);
	}
	
	private function convertToDate() 
	{
		foreach ($this->rows as $key => $value) {
			$this->rows[$key]['date'] = date('d.m.Y', $value['date']);
		}
	}


	private function groupByDate() 
	{
		$uniqueDates = array_unique(array_column($this->rows, 'date'));
		$rows = [];
		
		foreach ($uniqueDates as $uniqueDate) {
			$matches = array_filter($this->rows, function($date) use ($uniqueDate) {
				return $date['date'] == $uniqueDate;
			});
			
			$origValues = array_column($matches, 'origValue');
			$row = [
				'date' => $uniqueDate,
				'origValues' => $origValues
			];
			
			array_push($rows, $row);
		}
		
		$this->rows = $rows;
	}
	
	private function calc($range) 
	{
		if (!array_key_exists($range, self::RANGE))
			trigger_error('Range '.$range.' is not defined', E_USER_ERROR);
		
		$rangeValue = self::RANGE[$range];

		foreach (array_keys($this->rows) as $row) {
			if ($row < $rangeValue - 1) {
				$this->rows[$row]['maValue'] = '-';
				continue;
			}
			
			$offset = $row - ($rangeValue - 1);
			$slice = array_slice($this->rows, $offset, $rangeValue);
			$origValues = array_column($slice, 'origValues');
			$averageValues = [];
			
			foreach ($origValues as $origValue) {
				$averageValue = array_sum($origValue) / count($origValue);
				array_push($averageValues, $averageValue);
			}
			
			$sum = array_sum($averageValues);
			$maValue = $sum / $rangeValue;
			$this->rows[$row]['maValue'] = $maValue;
		}
	}
}