<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	require_once ('./inc/db/searchProfile.php');
	require_once ('./modules/import/CsvParser.php');
	$dbProfile = new dbProfile();
	$dbSearchProfile = new dbSearchProfile();

	// wybrany profil
	$profil = empty($_GET['profil']) ? 0 : intval($_GET['profil']);

	//
	// Przetwarzanie danych
	//
	$tplData = array();

	// search type
	$tplData['search-type'] = $pv_controller->action == 'w puli' ? 'profile' : 'free';

	// spr. liczników
	$dbProfile->pf_getStats($tplData['grupy_liczniki'], 'grupy');

	// search-profiles
	if ($tplData['search-type'] == 'profile') {
		$dbSearchProfile->pf_getRecords($tplData['search_profiles']
			, array(
				'row_state' => CsvRowState::OK
			)
			, array(
				'id',
				'group_name',
				'sex',
				'region',
				'age_min',
				'age_max',
				'education',
				'transport',
			)
		);
		$hasSearchProfiles = !empty($tplData['search_profiles']);
		if (!$hasSearchProfiles) {
			$tplData['search-type'] = 'free';
		}
		
		// profile pre-parse
		if ($hasSearchProfiles) {
			foreach ($tplData['search_profiles'] as &$sp_row)
			{
				// domyślnie pierwszy profil
				if ($profil < 1) {
					$profil = $sp_row['id'];
				}
				// wykształcenie
				$sp_row['education_long'] = dbProfile::pf_wyksztalcenieTranslate($sp_row['education']);
				$sp_row['age_range'] = dbProfile::pf_ageRangeTranslate($sp_row['age_min'], $sp_row['age_max']);

				if ($profil == $sp_row['id']) {
					$tplData['selected_profile_row'] = $sp_row;
				}
			}
			$tplData['selected_profile_id'] = $profil;
		}
	}

	// wrong group check
	$tplData['wrong-group'] = false;
	if ($configHelper->panel_stage != 'results' && $pv_controller->action != 'w puli')
	{
		$tplData['wrong-group'] = true;
	}
	
	// wypełnienie pól wyboru
	$pv_ograniczeniaStats = array();
	if (!empty($pv_controller->action))
	{
		$pv_ograniczeniaStats['grupa'] = $pv_controller->action;
	}
	$dbProfile->pf_getStats($tplData['miejsce'], 'miejsce', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['wyksztalcenie'], 'wyksztalcenie', $pv_ograniczeniaStats);
	$dbProfile->pf_getStats($tplData['transport'], 'transport', $pv_ograniczeniaStats);

	$tplData['prev'] = array();
	$pv_choices = array('miejsce', 'plec', 'wyksztalcenie', 'wiek_od', 'wiek_do', 'transport', 'wiek', 'profil');
	foreach ($pv_choices as $choice)
	{
		$tplData['prev'][$choice] = (!empty($_POST[$choice])) ? $_POST[$choice] : '';
	}
	if (empty($tplData['prev']['wyksztalcenie']))
	{
		$tplData['prev']['wyksztalcenie'] = array();
	}

	$tplData['search-submited'] = !empty($_POST['search']);

	if (!empty($_POST['search']))
	{
		// radio or single value
		$pv_allow = array('miejsce', 'plec', 'wyksztalcenie', 'transport');
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
			array('id', 'ankieta_id', 'miejsce', 'plec', 'wiek', 'wyksztalcenie', 'transport', 'grupa')
		);
	}

	$pv_controller->tpl->file = 'search.tpl.php';
	$pv_controller->tpl->data = $tplData;

	//
	// Wyświetlanie template
	//
	$pv_controller->tpl->render();
?>