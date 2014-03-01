<?php
	require_once ('./inc/dbConnect.php');
	require_once ('./inc/db/profile.php');

	$dbProfile = new dbProfile();
	$dbProfile->pf_getRecords($pv_array, array('dzielnica' => 'Wrzeszcz Dolny'));
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