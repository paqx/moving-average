<?php

namespace Paquix\Ma;

use SplFileObject;

class CsvParser 
{
	private $parsedRows = [];
	
	public function __construct(string $csvFile, $separator, bool $ignoreHeader = false, array $columns) 
	{
		if (!file_exists($csvFile))
			trigger_error('Data file '.$csvFile.' not found', E_USER_ERROR);
		
		if (count($columns) == 0)
			trigger_error('You must select at least one column for parsing', E_USER_ERROR);
		
		$csvTable = new SplFileObject($csvFile);
		
		while (!$csvTable->eof()) {
			$csvRow = $csvTable->fgets();
			
			if ($ignoreHeader) {
				$ignoreHeader = false;
				continue;
			}
			
			$row = explode($separator, $csvRow);
			$parsedRow = [];
			$allKeysSet = true;

			foreach ($columns as $index => $key) {
				if (isset($row[$index]))
					$parsedRow[$key] = trim($row[$index], '\"\"');
				else
					$allKeysSet = false;
			}
			
			if ($allKeysSet)
				array_push($this->parsedRows, $parsedRow);
		}

		$csvTable = null;
	}
	
	public function getParsedRows(): array
	{
		return $this->parsedRows;
	}
}