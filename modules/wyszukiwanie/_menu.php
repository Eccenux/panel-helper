<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Wyszukiwanie';
	$pv_menuItem->order = 2;
	
	require_once ('./inc/db/profile.php');
	foreach (dbProfile::$pv_grupy as $grupa)
	{
		$pv_menuItem->addSubItem($grupa);
	}
?>