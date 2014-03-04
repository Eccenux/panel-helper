<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	$dbProfile = new dbProfile();

	//
	// Przetwarzanie danych
	//
	$tplData = array();
	// filtrowanie po grupie
	$pv_ograniczeniaStats = array();
	if (!empty($pv_controller->action))
	{
		$pv_ograniczeniaStats['grupa'] = $pv_controller->action;
	}
	// statystyki
	$tplData['stats'] = array();
	$dbProfile->pf_getStats($tplData['stats']['dzielnice'], 'dzielnice', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['stats']['wyksztalcenie'], 'wyksztalcenie', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['stats']['plec'], 'plec', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['stats']['wiek'], 'wiek', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['stats']['dzieci'], 'dzieci', $pv_ograniczeniaStats);

	$pv_controller->tpl->file = 'stats.tpl.php';
	$pv_controller->tpl->data = $tplData;

	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>