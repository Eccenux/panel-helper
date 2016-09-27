<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Wyszukiwanie';
	$pv_menuItem->order = 2;
	if ($configHelper->panel_stage == 'results')
	{
		$pv_menuItem->users = '';
	}
	else if ($configHelper->panel_stage != 'tests')
	{
		$pv_menuItem->users = 'admin,maciej.j,marcin.g';
	}
	
	require_once ('./inc/db/profile.php');
	foreach (dbProfile::$pv_grupy as $grupa)
	{
		$pv_menuItem->addSubItem($grupa);
	}
?>