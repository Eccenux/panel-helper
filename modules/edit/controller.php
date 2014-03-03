<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	$dbProfile = new dbProfile();

	//
	// Przetwarzanie danych
	//
	switch ($pv_controller->action)
	{
		case 'grupa':
			$grupa = empty($_GET['grupa']) ? '' : $_GET['grupa'];
			$id = empty($_GET['id']) ? '' : $_GET['id'];
			if (empty($id))
			{
				$pv_controller->tpl->message = 'Brak identyfikatora!';
			}
			if ($dbProfile->pf_setRecords(array('grupa' => $grupa), array('id' => $id)))
			{
				$pv_controller->tpl->message = 'OK['.$id.']'.$grupa;
			}
			else
			{
				$pv_controller->tpl->message = 'Błąd!';
			}
		break;
		default:
				$pv_controller->tpl->message = 'Nie używaj bezpośrednio';
		break;
	}

	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>