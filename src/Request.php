<?php

namespace Paquix\Ma;

class Request
{
	private $method;
	private $uri;
	private $uriParams = [];
			
	public function __construct() 
	{
		$this->method = $_SERVER['REQUEST_METHOD'];
		$uri = strtok($_SERVER['REQUEST_URI'], '?');
		$this->uri = $uri;
		$this->uriParams = $_GET;
	}
	
	public function getMethod() 
	{
		return $this->method;
	}
	
	public function getUri() 
	{
		return $this->uri;
	}
	
	public function getUriParam(string $uriParam) 
	{
		return $this->uriParams[$uriParam] ?? null;
	}
}