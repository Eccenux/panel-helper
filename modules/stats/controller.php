<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	$dbProfile = new dbProfile();

	//
	// Przetwarzanie danych
	//
	$tplData = array();

	// dane użytkownika
	$tplData['prev'] = array();
	$pv_choices = array('grupa');
	foreach ($pv_choices as $choice)
	{
		$tplData['prev'][$choice] = (!empty($_POST[$choice])) ? $_POST[$choice] : '';
	}
	if (empty($tplData['prev']['grupa']))
	{
		$tplData['prev']['grupa'] = array();
	}

	// filtrowanie po grupie
	$pv_ograniczeniaStats = array();
	if (!empty($tplData['prev']['grupa']))
	{
		$pv_ograniczeniaStats['grupa'] = array('IN', $tplData['prev']['grupa']);
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