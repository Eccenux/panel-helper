<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	$dbProfile = new dbProfile();

	if ($configHelper->panel_stage != 'draw' && $configHelper->panel_stage != 'tests')
	{
		$pv_controller->action = 'end';
	}

	//
	// Przetwarzanie danych
	//
	switch ($pv_controller->action)
	{
		case 'grupa':
			$grupa = empty($_GET['grupa']) ? '' : $_GET['grupa'];
			$id = empty($_GET['id']) ? '' : $_GET['id'];
			$searchProfileId = empty($_GET['search_profile_id']) ? -1 : intval($_GET['search_profile_id']);
			
			$record = array('grupa' => $grupa);
			// jeśli nie wybrany profil, to go nie zmieniamy
			// dzięki temu można zmienić przypadkowo wybraną grupę główną na zastępczą i zachować przypisanie do profilu
			// (to znaczy można to zrobić mimo wybrania swobodnego wyszukiwania)
			if ($searchProfileId > 0) {
				$record['search_profile_id'] = $searchProfileId;
			}

			if (empty($id))
			{
				$pv_controller->tpl->setResponseCode(400);
				$pv_controller->tpl->message = 'Brak identyfikatora!';
			}
			else if ($dbProfile->pf_setRecords($record, array('id' => $id)))
			{
				$pv_controller->tpl->message = 'OK['.$id.']'.$grupa;
			}
			else
			{
				$pv_controller->tpl->setResponseCode(500);
				$pv_controller->tpl->message = 'Nie udało się zapisać danych!';
			}
		break;
		case 'end':
			$pv_controller->tpl->setResponseCode(403);
			$pv_controller->tpl->message = 'Losowanie zakończone';
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