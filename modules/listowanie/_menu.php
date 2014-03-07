<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Listowanie';
	$pv_menuItem->order = 3;
	$pv_menuItem->users = 'anon,maciej.j,operator';
	
	require_once ('./inc/db/profile.php');
	foreach (dbProfile::$pv_grupy as $grupa)
	{
		if ($grupa == 'w puli' || $grupa == 'robocza')
		{
			continue;
		}
		$pv_menuItem->addSubItem($grupa);
	}
?>