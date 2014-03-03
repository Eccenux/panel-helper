<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Listowanie';
	$pv_menuItem->order = 3;
	
	require_once ('./inc/db/profile.php');
	foreach (dbProfile::$pv_grupy as $grupa)
	{
		if ($grupa == 'w puli')
		{
			continue;
		}
		$pv_menuItem->addSubItem($grupa);
	}
?>