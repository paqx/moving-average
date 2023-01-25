<?php

namespace Paquix\Ma;

use Paquix\Ma\Config;

class View
{
	public static function render(string $template, string $view, array $params = null) 
	{
		if (!is_null($params))
			extract($params);
		
		$templatesDir = Config::get('TEMPLATES_DIR');
		$viewsDir = Config::get('VIEWS_DIR');

		ob_start();
		include($viewsDir.'/'.$view.'.php');
		$content = ob_get_clean();
		include($templatesDir.'/'.$template.'.php');
	}
}