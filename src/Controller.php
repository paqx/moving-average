<?php

namespace Paquix\Ma;

use Paquix\Ma\Request;
use Paquix\Ma\View;
use Paquix\Ma\CsvParser;
use Paquix\Ma\MaTable;

class Controller
{
	public function index() 
	{
		$request = new Request();
		$range = Config::get('RANGE');
		$maTable = new MaTable($range);
		$maTable->paginate($request->getUriParam('page'));
		$rows = $maTable->getRows();

		return View::render('default', 'index', [
			'rows' => $rows,
			'nextPage' => $maTable->getNextPage(),
			'prevPage' => $maTable->getPrevPage(),
		]);
	}
	
	public function failover()
	{
		http_response_code(404);
		
		return View::render('error', '404');
	}
}