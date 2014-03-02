<?
	/* @var $pv_controller ModuleController */

	//
	// Przetwarzanie danych
	//
	switch ($pv_controller->action)
	{
		default:
			$pv_controller->tpl->file = 'compare.tpl.php';
			$pv_controller->tpl->data = array(
				'rozkladUrl' => $pv_controller->getActionUrl('charts', array('display'=>'raw', 'chart'=>'rozklad')),
				'wzorzecUrl' => $pv_controller->getActionUrl('charts', array('display'=>'raw', 'chart'=>'wzorzec')),
			);
		break;
		case 'charts':
			$chart = empty($_GET['chart']) ? '' : $_GET['chart'];
			switch ($chart)
			{
				case 'rozklad':
				case 'wzorzec':
				break;
				default:
					$chart = '';
				break;
			}
			if (empty($chart))
			{
				$pv_controller->tpl->message = '&mdash;';
			}
			else
			{
				$pv_controller->tpl->file = 'charts.tpl.php';
				$pv_controller->tpl->data = array(
					'chartDataPath' => $pv_controller->modulePublicDir.$chart.'/',
				);
			}
		break;
	}


	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>