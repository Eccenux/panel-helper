<?php
	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');
	require_once ('./inc/db/personal.php');

	$dbProfile = new dbProfile();
	$dbPersonal = new dbPersonal();
	/**
	 * "Stat"
	 */
	$dbProfile->pf_getStats($tplData['dzielnice'], 'dzielnice');
	var_export($tplData['dzielnice']);
	/**
	 * Simple&in-exact test
	 *
	$dbProfile->pf_getRecords($pv_array, array('dzielnica' => 'Wrzeszcz Dolny'));
	var_export($pv_array);
	$dbPersonal->pf_getRecords($pv_array, array('imie' => '%ac%'), array(), false);
	var_export($pv_array);
	/**
	 * Get/set test
	 *
	var_export($pv_array[0]);
	$id = $pv_array[0]['id'];
	$prev = $pv_array[0]['plec'];
	$pv_array[0]['plec'] = '123';
	$dbProfile->pf_setRecords($pv_array[0], array('id' => $id));
	$dbProfile->pf_getRecords($pv_array, array('id' => $id));
	var_export($pv_array);
	$pv_array['plec'] = $prev;
	$dbProfile->pf_setRecords($pv_array, array('id' => $id));
	$dbProfile->pf_getRecords($pv_array, array('id' => $id));
	var_export($pv_array);
	/**/
?>