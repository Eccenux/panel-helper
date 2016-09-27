<?php
require_once './inc/config.php';

class ConfigHelper
{
	function __construct()
	{
	}

	public function __get($key)
	{
		switch ($key)
		{
			case 'panel_stage':
				return (defined('PANEL_STAGE') && constant('PANEL_STAGE') == 'draw') ? 'draw' : 'results';
			case 'require_secure_connection':
				return defined('REQUIRE_SECURE_CONNECTION') && constant('REQUIRE_SECURE_CONNECTION');
		}
		return null;
	}
}

$configHelper = new ConfigHelper();