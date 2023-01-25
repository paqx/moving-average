<?php

namespace Paquix\Ma;

class Config 
{
	const CONFIG_FILE = __DIR__.'/../config.php';

	private $config = [];
	
	public function __construct() 
	{
		$configFile = self::CONFIG_FILE;
		
		if (!file_exists($configFile))
			trigger_error('Config file '.$configFile.' not found', E_USER_ERROR);
		
		$config = require $configFile;
		$this->config = $config;
	}

	public static function get(string $key): string 
	{
		$self = new static;
		
		if (isset($self->config[$key]))
			return $self->config[$key];
		else
			trigger_error('Key '.$key.' not found in config file '.$self->configFile, E_USER_ERROR);
	}
}