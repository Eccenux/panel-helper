<?php
require_once './inc/moduleTemplate.php';

/**
 * Controller helper.
 *
 * @author Maciej Nux Jaros
 */
class ModuleController
{
	/**
	 * Action within module received from user.
	 *
	 * If empty then default sub-controller for the module should be used.
	 * 
	 * @readonly
	 * @var string
	 */
	public $action;
	/**
	 * @readonly
	 * @var string
	 */
	public $moduleDir;
	/**
	 * Main controller file path.
	 * @readonly
	 * @var string
	 */
	public $controllerPath;
	/**
	 * @readonly
	 * @var string
	 */
	public $moduleName;

	/**
	 * @var ModuleTemplate
	 */
	public $tpl;

	/**
	 * @param string $moduleName Module name.
	 * @param string $action Action within module.
	 */
	public function __construct($moduleName, $action)
	{
		$this->moduleName = $moduleName;
		$this->moduleDir = './modules/'.$moduleName.'/';
		$this->controllerPath = './modules/'.$moduleName.'/controller.php';
		$this->action = $action;
		$this->tpl = new ModuleTemplate($this->moduleDir);
	}
}
