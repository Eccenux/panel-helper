<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Statystyki';
	$pv_menuItem->order = 4;
	
	require_once ('./inc/db/profile.php');
	foreach (dbProfile::$pv_grupy as $grupa)
	{
		$pv_menuItem->addSubItem($grupa);
	}
?>