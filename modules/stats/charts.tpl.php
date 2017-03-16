<?php
	// stat that should have chart below others
	// (use for large chart or less important stat or something like that)
	$bottomStat = 'miejsce';

	$currentRoot = dirname(__FILE__);
	require_once $currentRoot.'/filter.tpl.php';
	require_once $currentRoot.'/wzorzec.data.php';
	$pv_max = array();
	if (!function_exists('array_column')) {
		function array_column($input, $columnKey, $indexKey = null) {
			$result = array();

			if (null === $indexKey) {
				if (null === $columnKey) {
					// trigger_error('What are you doing? Use array_values() instead!', E_USER_NOTICE);
					$result = array_values($input);
				}
				else {
					foreach ($input as $row) {
						if (isset($row[$columnKey])) {
							$result[] = $row[$columnKey];
						}
					}
				}
			}
			else {
				if (null === $columnKey) {
					foreach ($input as $row) {
						if (isset($row[$indexKey])) {
							$result[$row[$indexKey]] = $row;
						}
					}
				}
				else {
					foreach ($input as $row) {
						if (isset($row[$indexKey]) && isset($row[$columnKey])) {
							$result[$row[$indexKey]] = $row[$columnKey];
						}
					}
				}
			}

			return $result;
		}
	}
?>

<!-- base libraries -->
<script type="text/javascript" src="js/gfa-charts/js/logger.js"></script>
<script type="text/javascript" src="js/gfa-charts/js/questions.js"></script>

<!-- chart libraries -->
<script type="text/javascript" src="js/gfa-charts/js/charts/amcharts/amcharts.js"></script>
<script type="text/javascript" src="js/gfa-charts/js/charts/color.js"></script>
<script type="text/javascript" src="js/gfa-charts/js/charts/colorGenerator.js"></script>
<script type="text/javascript" src="js/gfa-charts/js/charts/charts.js"></script>

<script type="text/javascript" src="modules_public/wizualizacje/wzorzec/summaryData.js"></script>

<!-- wykresy -->
<div style='float:left; width:570px;'>
	<h2>Dane z losowania</h2>
	<?php
		foreach($tplData['stats'] as $statName=>$stats)
		{
			$pv_max[$statName] = 0;
			if (!empty($stats)) {
				$pv_max[$statName] = max(array_column($stats, 'licznik'));
			}
			if (empty($pv_max[$statName])) {
				continue;
			}
			if ($statName != $bottomStat)
			{
				echo "<div id='chart-container-$statName' style='float:left; width:270px; height:200px;'></div>";
			}
		}
	?>
	<br clear="all" />
	<div id='chart-container-<?=$bottomStat?>' style='width:550px; height:600px;'></div>
</div>
<div style='float:left; width:570px; margin-left: 2em;'>
	<h2>Ogólne dane statystyczne</h2>
	<?php
		foreach($pv_wzorzecData as $statName=>$stats)
		{
			if (!empty($pv_max[$statName])) {
				$pv_max_tmp = max(array_column($stats, 'value'));
				$pv_max[$statName] = max($pv_max[$statName], $pv_max_tmp);
			}
			if ($statName != $bottomStat)
			{
				echo "<div id='chart-container-wzorzec-$statName' style='float:left; width:270px; height:200px;'></div>";
			}
		}
	?>
	<br clear="all" />
	<div id='chart-container-wzorzec-<?=$bottomStat?>' style='width:550px; height:600px;'></div>
</div>
<br clear="all" />

<!-- dane -->
<script type="text/javascript">
	var chartData;
	<?php
		foreach($tplData['stats'] as $statName=>$stats) {
			if (empty($stats) || empty($pv_max[$statName])) {
				continue;
			}
			$chartData = array();
			foreach($stats as $stat) {
				$s = array_values($stat);
				$chartData[] = array('title'=>$s[0], 'value'=>$s[1]);
			}
			echo "\nchartData = ". json_encode($chartData);
			echo "\ncharts.bar(chartData, 'chart-container-$statName', {$pv_max[$statName]});";
		}
	?>
	<?php
		foreach($pv_wzorzecData as $statName=>$chartData) {
			$pv_statMax = empty($pv_max[$statName]) ? 'false' : $pv_max[$statName];
			echo "\nchartData = ". json_encode($chartData);
			echo "\ncharts.bar(chartData, 'chart-container-wzorzec-$statName', {$pv_statMax});";
		}
	?>
</script>
