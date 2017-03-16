<?php
// rescale to expected total
function reScaleData($fraction) {
	$total = 56;
	return round($fraction * $total, 1);
}

$pv_wzorzecData = array(
	"wyksztalcenie" => array(
		array (
			"title" => "p",
			"value" => reScaleData(12.8/100),
		),
		array (
			"title" => "ś",
			"value" => reScaleData(57.1/100),
		),
		array (
			"title" => "w",
			"value" => reScaleData(30.1/100),
		)
	),
	"plec" => array(
		array (
			"title" => "kobieta",
			"value" => reScaleData(54.4/100),
		),
		array (
			"title" => "mężczyzna",
			"value" => reScaleData(45.6/100),
		),
	),
	"wiek" => array(
		array (
			"title" => "18-24",
			"value" => reScaleData(6.5/100),
		),
		array (
			"title" => "25-39",
			"value" => reScaleData(27.6/100),
		),
		array (
			"title" => "40-64",
			"value" => reScaleData(39.9/100),
		),
		array (
			"title" => "65+",
			"value" => reScaleData(26.0/100),
		)
	),
);