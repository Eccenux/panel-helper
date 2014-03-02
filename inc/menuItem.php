<?php
/**
 * Menu item (entry) for the module.
 *
 * Allows incjectiong either a single menu item or an item with submenu (sub-entries).
 * So this is basically li or li > ul.
 *
 * @author Maciej Nux Jaros
 */
class MenuItem
{
	/**
	 * Module name as set by __construct().
	 * @readonly
	 * @var string
	 */
	public $moduleName;
	/**
	 * Title of the module shown to the user in menu.
	 * @var string
	 */
	public $title;
	/**
	 * [optional] A number used to order main menu items (if not given then sorting by module name).
	 * @var int|null
	 */
	public $order = null;
	/**
	 * [optional] Custom URL (i.e. not linking to a module).
	 * @var string|null
	 */
	public $url = null;
	/**
	 * [optional,todo] Users allowed to use this module/action
	 * @var string
	 */
	public $users = null;

	/**
	 * Submenu items.
	 * @readonly Use addSubItem instead.
	 * @var array
	 */
	public $submenu = array();

	/**
	 * @param type $moduleName Keep it set autmatically as a dirname of the module; unless you have a realy good reason not too ;-)
	 */
	public function __construct($moduleName)
	{
		$this->moduleName = $moduleName;
	}

	/**
	 * Add (append) submenu item.
	 * @param type $action Action name.
	 * @param type $title Title.
	 */
	public function addSubItem($action, $title)
	{
		$this->submenu[] = array (
			'action' => $action,
			'title' => $title,
		);
	}
}
