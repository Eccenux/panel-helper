<?
	/* @var $pv_controller ModuleController */

	require_once ('./inc/dbConnect.php');

	//
	// Crunch data
	//
	include $pv_controller->moduleDir.'/controller.import.profile.php';

	//
	// Render prepared template
	//
	$pv_controller->tpl->render();
?>