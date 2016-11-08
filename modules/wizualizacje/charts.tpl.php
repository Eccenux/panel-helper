<!DOCTYPE html>
<html>
<head>
	<title>Panel &bull; ankieta</title>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="author" content="Maciej Jaros">
	<meta name="copyright" content="Maciej Jaros">

	<!-- can't be bothered (at least for now) -->
	<script type="text/javascript" src="js/gfa-charts/js/mustardTest.js"></script>

	<!-- base libraries -->
	<script type="text/javascript" src="js/gfa-charts/js/logger.js"></script>
	<script type="text/javascript" src="js/gfa-charts/js/questions.js"></script>

	<!-- chart libraries -->
	<script type="text/javascript" src="js/gfa-charts/js/charts/amcharts/amcharts.js"></script>
	<script type="text/javascript" src="js/gfa-charts/js/charts/color.js"></script>
	<script type="text/javascript" src="js/gfa-charts/js/charts/colorGenerator.js"></script>
	<script type="text/javascript" src="js/gfa-charts/js/charts/charts.js"></script>

	<script type="text/javascript" src="js/gfa-charts/js/chartsRenderer.js"></script>

	<!-- survey specific data -->
	<script type="text/javascript" src="<?=$tplData['chartDataPath']?>summaryData.js?0003"></script>
	<script type="text/javascript" src="<?=$tplData['chartDataPath']?>questionsData.js?0003"></script>
	<script type="text/javascript" src="<?=$tplData['chartDataPath']?>filterSets.js?0003"></script>

	<link rel="stylesheet" href="js/gfa-charts/index.css" />
</head>
<body lang="pl">
	<!-- content -->
	<div id="filter-sets" style="display: none;">
		<label>Wybierz zestawienie</label>
		<select id="filter-set">
		</select>
	</div>
	<div id="summary"></div>
	<script type="text/javascript" src="js/gfa-charts/js/controller.js"></script>
</body>
</html>