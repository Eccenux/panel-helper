<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	require_once ('./inc/db/personal.php');
	$dbProfile = new dbProfile();
	$dbPersonal = new dbPersonal();

	//
	// Przetwarzanie danych
	//
	$tplData = array();
	// pl->ascii
	$tplData['grupa_ascii'] = strtr($pv_controller->action, array(
		' '=>'_',
		'ż'=>'z',
		'ó'=>'o',
		'ł'=>'l',
		'ć'=>'c',
		'ę'=>'e',
		'ś'=>'s',
		'ą'=>'a',
		'ź'=>'z',
		'ń'=>'n',
	));
	// wypełnienie pól wyboru
	$pv_ograniczeniaStats = array();
	if (empty($pv_controller->action) || !in_array($pv_controller->action, dbProfile::$pv_grupy)
			|| $pv_controller->action == 'w puli')
	{
		$pv_controller->tpl->message = 'Wybierz grupę';
	}
	else
	{
		$dbProfile->pf_getRecords($profiles, array('grupa'=>$pv_controller->action), array('id', 'ankieta_id'));
		// array_column($profiles, 'id')
		$ids = array();
		$tplData['poll_ids'] = array();
		foreach ($profiles as $item) {
			$ids[] = $item['id'];
			$tplData['poll_ids'][] = array('ankieta_id'=>$item['ankieta_id']);
		}

		if (empty($ids))
		{
			$pv_controller->tpl->message = 'Brak osób w tej grupie.';
		}
		else
		{
			$dbPersonal->pf_getRecords($tplData['personal'], array('id'=>array('IN', $ids)), array('nazwisko_imie', 'e_mail', 'nr_tel'));

			$pv_controller->tpl->file = 'list.tpl.php';
			$pv_controller->tpl->data = $tplData;
		}
	}

	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>