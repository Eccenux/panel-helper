<?php
	$currentRoot = dirname(__FILE__);
	require_once $currentRoot.'/filter.tpl.php';
	require_once $currentRoot.'/wzorzec.data.php';
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
			if ($statName != 'dzielnice')
			{
				echo "<div id='chart-container-$statName' style='float:left; width:270px; height:200px;'></div>";
			}
			if (empty($stats)) {
				break;
			}
		}
	?>
	<br clear="all" />
	<div id='chart-container-dzielnice' style='width:550px; height:600px;'></div>
</div>
<div style='float:left; width:570px; margin-left: 2em;'>
	<h2>Ogólne dane statystyczne</h2>
	<?php
		foreach($pv_wzorzecData as $statName=>$stats)
		{
			echo "<div id='chart-container-wzorzec-$statName' style='float:left; width:270px; height:200px;'></div>";
		}
	?>
	<br clear="all" />
</div>
<br clear="all" />

<!-- dane -->
<script type="text/javascript">
	var chartData;
	<?php
		foreach($tplData['stats'] as $statName=>$stats) {
			$chartData = array();
			foreach($stats as $stat) {
				$s = array_values($stat);
				$chartData[] = array('title'=>$s[0], 'value'=>$s[1]);
			}
			echo "\nchartData = ". json_encode($chartData);
			if ($statName == 'dzielnice')
			{
				echo "\ncharts.bar(chartData, 'chart-container-$statName');";
			}
			else
			{
				echo "\ncharts.bar(chartData, 'chart-container-$statName');";
			}
		}
	?>
	<?php
		foreach($pv_wzorzecData as $statName=>$chartData) {
			echo "\nchartData = ". json_encode($chartData);
			echo "\ncharts.bar(chartData, 'chart-container-wzorzec-$statName');";
		}
	?>
</script>
