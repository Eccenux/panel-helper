<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <? $pv_page_title = empty($pv_page_title) ? 'Panel Helper' : htmlspecialchars($pv_page_title) . ' &bull; Panel Helper';?>
    <title><?=$pv_page_title?></title>
	<link rel="stylesheet" type="text/css" media="screen" href="css/main.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/colors.css">
	<meta name="author" content="Maciej Jaros">
	<meta name="copyright" content="Maciej Jaros">

	<!-- jQuery -->
	<link type="text/css" href="./js/jquery/css/ui-lightness/jquery-ui-custom.css" rel="stylesheet">
	<script type="text/javascript" src="./js/jquery/js/jquery-min.js"></script>
	<script type="text/javascript" src="./js/jquery/js/jquery-ui-custom.min.js"></script>
	
	<!-- jQuery inits and other global stuff -->
	<script type="text/javascript" src="./js/prepare-std.js"></script>

	<!-- History API: http://balupton.com/projects/jquery-history -->
	<script type="text/javascript" src="./js/native.history.js"></script>

	<!-- with and without JS visibility and display -->
	<style type="text/css">
	.withJSvisible {visibility: hidden}
	.withJSdisplay {display:none}
	</style>
	<script language="JavaScript" type="text/javascript">
	document.write(String.fromCharCode(60),'style type="text/css"',String.fromCharCode(62),
			' .withJSvisible {visibility:visible !important} ',
			' .withoutJSvisible {visibility:hidden !important}  ',
			
			' span.withJSdisplay {display:inline !important} div.withJSdisplay {display:block !important} ',
			' .withoutJSdisplay {display:none !important} ',
			String.fromCharCode(60),'/style',String.fromCharCode(62)
	);
	</script>
    <?=$pv_controller->tpl->extraHeadTags?>
</head>
<body lang="pl">
	<div id="container">
		<div id="header">
			<div id="logo"></div><p><a href="index.php"><?=$pv_page_title?></a></p>
			<div id="stage"><?php
				switch ($configHelper->panel_stage)
				{
					case 'tests':
						echo 'Etap testów';
					break;
					case 'draw':
						echo 'Etap losowania';
					break;
					case 'results':
						echo 'Etap wyników';
					break;
				}
			?></div>
		</div>
		<div id="menu">
			<?=$pv_mainMenu?>
		</div>
		<div id="content">
			<?=$pv_page_content?>
		</div>
		<div id="footer">
			<p>Copyright &copy;2014-2016 Maciej Jaros.</p>
		</div>
	</div>
	<script>
		(function($){
			function setHeight() {
				document.getElementById('content').style.cssText = '';
				var min = $(window).height() - ( $('#header').height() +  $('#footer').height() );
				// box-sizinig required(!)
				document.getElementById('content').style.cssText = 'min-height:'+ min +'px';
			}
			setHeight();
			window.addEventListener('load', setHeight);
			window.addEventListener('resize', setHeight);
		})(jQuery);
	</script>
</body>
</html>