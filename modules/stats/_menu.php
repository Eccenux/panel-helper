<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Statystyki';
	$pv_menuItem->order = 4;
	//$pv_menuItem->users = 'anon,maciej.j,operator';
	
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