<?
	/**
		@file Import profili zaproszeniowych.
	*/
	if ( !defined('NOT_HACKING_RILI') )
	{
		die("No hacking allowded ;).");
	}
	
	require_once ('./inc/db/searchProfile.php');
	$dbSearchProfile = new dbSearchProfile();

	$tplData = array();

	// save
	if (!empty($_POST['save']) && !empty($_FILES['csv']) && !empty($_FILES['csv']["tmp_name"])) {
		//echo "<pre>".var_export($_POST, true)."</pre>";
		//echo "<pre>".var_export($_FILES, true)."</pre>";

		require_once ('CsvParser.php');
		require_once ('CsvParser.profile.php');
		require_once ('ImportHelper.php');

		// parse and save file
		$helper = new ImportHelper($columnParsers, 'profile');
		$helper->parse($_FILES['csv'], $_POST['order']);
		$saveStatus = $helper->save(function($record, $rowState, $fileId) use ($dbSearchProfile) {
			return ImportHelper::insRecord($dbSearchProfile, $record, $rowState, $fileId);
		});
		// cleanup if saved...
		if ($saveStatus) {
			// remove previous records
			if (!empty($_POST['overwrite']) && $_POST['overwrite'] === 'y') {
				$dbSearchProfile->pf_delRecords(array('csv_file' => array('!=', $helper->fileId)));
			}
			// re-number ids (to start from 1)
			//$dbSearchProfile->pf_renumberIds();
		}
		$tplData['parserInfo'] = $helper->infoBuild();
	}
	
	// get
	$tplData['profile-summary'] = array();
	$dbSearchProfile->pf_getStats($tplData['profile-summary'], 'total', array(
		'row_state' => 0
	));

	// define CSV columns
	$tplData['columns'] = array(
		//null,	// skip
		array(
			'column' => 'sex',
			'title' => 'Płeć',
		),
		array(
			'column' => 'age_min_max',
			'title' => 'Wiek (zakres)',
		),
		array(
			'column' => 'education',
			'title' => 'Wykształcenie',
		),
		array(
			'column' => 'transport',
			'title' => 'Transport',
		),
		array(
			'column' => 'region',
			'title' => 'Region',
		),
		array(
			'column' => 'group_name',
			'title' => 'Grupa',
		),
	);

	// prepare data for render
	$pv_controller->tpl->data = $tplData;
	$pv_controller->tpl->file = 'controller.import.profile.tpl.php';
?>