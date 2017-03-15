<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/eventHistory.php');
	$dbEventHistory = new dbEventHistory();

	//
	// Przetwarzanie danych
	//
	switch ($pv_controller->action)
	{
		case 'save':
			$uuid = empty($_POST['uuid']) ? '' : $_POST['uuid'];
			$pv_record = array (
				'uuid' => $uuid,
				'history_data' => empty($_POST['data']) ? '' : $_POST['data'],
			);
			if (empty($uuid)) {
				$pv_controller->tpl->setResponseCode(400);
				$pv_controller->tpl->message = 'Brak identyfikatora!';
			} else {
				// check prev.
				$pv_prev = array();
				$dbEventHistory->pf_getRecords($pv_prev, array('uuid' => $uuid), array('uuid'));
				$result = true;
				if (!empty($pv_prev)) {
					$result = $dbEventHistory->pf_setRecords($pv_record, array('uuid' => $uuid));
				} else {
					$result = $dbEventHistory->pf_insRecord($pv_record);
				}
				if ($result) {
					$pv_controller->tpl->message = "OK[$uuid] " . (!empty($pv_prev) ? 'overwrite' : 'insert');
				}
				else {
					$pv_controller->tpl->setResponseCode(500);
					$pv_controller->tpl->message = 'Nie udało się zapisać danych!';
				}
			}
		break;
		default:
			$pv_controller->tpl->setResponseCode(403);
			$pv_controller->tpl->message = 'Nie używaj bezpośrednio';
		break;
	}

	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>