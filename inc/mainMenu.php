<?php
/**
 * Main menu helper.
 *
 * @author Maciej Nux Jaros
 */
class MainMenu implements Iterator
{
	private $items = array();
    public function __construct() {
    }

	// <editor-fold defaultstate="collapsed" desc="Iterator methods">
    function rewind() {
        reset($this->items);
    }
    function current() {
        return current($this->items);
    }
    function key() {
        return key($this->items);
    }
    function next() {
        next($this->items);
    }
    function valid() {
		$key = key($this->items);
		return ($key !== NULL && $key !== FALSE);
	}
	// </editor-fold>

	/**
	 * Add (append) menu item.
	 * @param MenuItem $menuItem Menu item.
	 */
	public function addItem($menuItem)
	{
		$this->items[$menuItem->moduleName] = $menuItem;
	}

	/**
	 * Sort items based on order options.
	 */
	private function sort()
	{
		// sort menu
		$menuOrder = array();
		$menuOrderNames = array();
		foreach ($this->items as $key => $row)
		{
			$menuOrder[$key]  = !is_null($row->order) ? $row->order : 9999;
			$menuOrderNames[$key]  = $key;
		}
		array_multisort($menuOrder, SORT_ASC, $menuOrderNames, SORT_ASC, $this->items);
	}

	/**
	 * Url helper.
	 * @param string $moduleName
	 * @param string $moduleAction
	 * @return string
	 */
	private function getModuleUrl($moduleName, $moduleAction='')
	{
		$url = "?mod={$moduleName}";
		if (!empty($moduleAction))
		{
			$url .= "&amp;a={$moduleAction}";
		}
		return $url;
	}

	/**
	 * Prepare items before rendenring.
	 */
	public function prepare()
	{
		$this->sort();

		// prepare urls
		foreach ($this->items as $mpoz)
		{
			if (empty($mpoz->url))
			{
				$mpoz->url = $this->getModuleUrl($mpoz->moduleName);
			}
			// one-level submenu
			if (!empty($mpoz->submenu))
			{
				foreach ($mpoz->submenu as &$subpoz)
				{
					if (empty($subpoz['url']))
					{
						$subpoz['url'] = $this->getModuleUrl($mpoz->moduleName, $subpoz['action']);
					}
				}
			}
		}
	}
}
