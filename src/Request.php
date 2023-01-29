<?php

namespace Paquix\Ma;

use Paquix\Ma\RequestInterface;

class Request implements RequestInterface
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
	
	public function getMethod(): string
	{
		return $this->method;
	}
	
	public function getUri(): string
	{
		return $this->uri;
	}
	
	public function getUriParam(string $uriParam): ?string
	{
		return $this->uriParams[$uriParam] ?? null;
	}
}