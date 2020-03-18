<?php
// rescale to expected total
function reScaleData($fraction) {
	$total = 75;
	return round($fraction * $total, 1);
}

$pv_wzorzecData = array(
	"wyksztalcenie" => array(
		array (
			"title" => "p",
			"value" => reScaleData(11.08/100),
		),
		array (
			"title" => "ś",
			"value" => reScaleData(55.66/100),
		),
		array (
			"title" => "w",
			"value" => reScaleData(33.27/100),
		)
	),
	"plec" => array(
		array (
			"title" => "kobieta",
			"value" => reScaleData(55.08/100),
		),
		array (
			"title" => "mężczyzna",
			"value" => reScaleData(44.92/100),
		),
	),
	"wiek" => array(
		array (
			"title" => "18-24",
			"value" => reScaleData(6.00/100),
		),
		array (
			"title" => "25-39",
			"value" => reScaleData(28.09/100),
		),
		array (
			"title" => "40-64",
			"value" => reScaleData(39.11/100),
		),
		array (
			"title" => "65+",
			"value" => reScaleData(26.81/100),
		)
	),
	"transport" => array(
		array (
			"title" => "auto",
			"value" => reScaleData(41.61/100),
		),
		array (
			"title" => "pieszo",
			"value" => reScaleData(24.32/100),
		),
		array (
			"title" => "rower",
			"value" => reScaleData(6.33/100),
		),
		array (
			"title" => "zbiorkom",
			"value" => reScaleData(27.74/100),
		),
	),
);