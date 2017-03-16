<?php
// rescale to expected total
function reScaleData($fraction) {
	$total = 65;
	return $fraction * $total;
}

$pv_wzorzecData = array(
	"wyksztalcenie" => array(
		array (
			"title" => "p",
			"value" => reScaleData(20/40),
		),
		array (
			"title" => "ś",
			"value" => reScaleData(13/40),
		),
		array (
			"title" => "w",
			"value" => reScaleData(7/40),
		)
	),
	"plec" => array(
		array (
			"title" => "kobieta",
			"value" => reScaleData(21/40),
		),
		array (
			"title" => "mężczyzna",
			"value" => reScaleData(19/40),
		),
	),
	"wiek" => array(
		array (
			"title" => "18-24",
			"value" => reScaleData(4/40),
		),
		array (
			"title" => "25-39",
			"value" => reScaleData(12/40),
		),
		array (
			"title" => "40-64",
			"value" => reScaleData(17/40),
		),
		array (
			"title" => "65+",
			"value" => reScaleData(7/40),
		)
	),
);