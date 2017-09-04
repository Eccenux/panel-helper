<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	$dbProfile = new dbProfile();

	//
	// Przetwarzanie danych
	//
	$tplData = array();
	// wypełnienie pól wyboru
	$pv_ograniczeniaStats = array();
	if (!empty($pv_controller->action))
	{
		$pv_ograniczeniaStats['grupa'] = $pv_controller->action;
	}
	$dbProfile->pf_getStats($tplData['miejsce'], 'miejsce', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['wyksztalcenie'], 'wyksztalcenie', $pv_ograniczeniaStats);

	$tplData['prev'] = array();
	$pv_choices = array('miejsce', 'plec', 'wyksztalcenie', 'wiek_od', 'wiek_do');
	foreach ($pv_choices as $choice)
	{
		$tplData['prev'][$choice] = (!empty($_POST[$choice])) ? $_POST[$choice] : '';
	}
	if (empty($tplData['prev']['wyksztalcenie']))
	{
		$tplData['prev']['wyksztalcenie'] = array();
	}

	if (!empty($_POST['search']))
	{
		// radio or single value
		$pv_allow = array('miejsce', 'plec', 'wyksztalcenie');
		$pv_ograniczenia = array();
		foreach ($pv_allow as $name)
		{
			if (!empty($_POST[$name]))
			{
				$pv_ograniczenia[$name] = $_POST[$name];
			}
		}
		// extra ograniczenia
		if (!empty($pv_controller->action))
		{
			$pv_ograniczenia['grupa'] = $pv_controller->action;
		}
		// checkbox
		/**
		if (!empty($_POST['wyksztalcenie']))
		{
			$pv_ograniczenia['wyksztalcenie'] = array('IN', $_POST['wyksztalcenie']);
		}
		/**/
		if (!empty($_POST['wiek_od']) || !empty($_POST['wiek_do']))
		{
			if (!empty($_POST['wiek_od'])) {
				$pv_ograniczenia['wiek'] = array('>=', intval($_POST['wiek_od']));
			}
			if (!empty($_POST['wiek_do'])) {
				$pv_ograniczenia['wiek '] = array('<=', intval($_POST['wiek_do']));
			}
		}
		// get
		$dbProfile->pf_getRecords($tplData['profiles'], $pv_ograniczenia, 
			array('id', 'ankieta_id', 'miejsce', 'plec', 'wiek', 'wyksztalcenie', 'grupa')
		);
	}

	$pv_controller->tpl->file = 'search.tpl.php';
	$pv_controller->tpl->data = $tplData;

	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>