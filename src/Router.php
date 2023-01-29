<?php

namespace Paquix\Ma;

use Paquix\Ma\RequestInterface;

class Router
{
	private $request;
	
	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
	}
	
	public function get(string $uri, array|callable $callback, array $params = null)
	{
		if ($this->request->getMethod() != 'GET' || $this->request->getUri() != $uri)
			return;
		
		$this->parseCallback($callback, $params);
		
		exit;
	}
	
	public function failover(array|callable $callback, array $params = null) 
	{
		$this->parseCallback($callback, $params);
	}
	
	private function parseCallback(array|callable $callback, array $params = null) 
	{
		if (is_array($callback)) {
			$controller = new $callback[0];
			$controller->{$callback[1]}($params);
		}
		
		if (is_callable($callback))
			call_user_func($callback, $params);
	}
}