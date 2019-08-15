<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
    <? $pv_page_title = empty($pv_page_title) ? 'Panel Helper' : htmlspecialchars($pv_page_title) . ' &bull; Panel Helper';?>
    <title><?=$pv_page_title?></title>
	
	<link rel="icon" type="image/png" href="images/logo.png" />
	
	<link rel="stylesheet" type="text/css" media="screen" href="css/main.css?0331">
	<link rel="stylesheet" type="text/css" media="screen" href="css/colors.css?0331">
	<link rel="stylesheet" type="text/css" media="screen" href="css/draw_history.css?0331">
	<meta name="author" content="Maciej Jaros">
	<meta name="copyright" content="Maciej Jaros">

	<!-- jQuery -->
	<link type="text/css" href="./js/jquery/css/ui-lightness/jquery-ui-custom.css?0331" rel="stylesheet">
	<script type="text/javascript" src="./js/jquery/js/jquery-min.js"></script>
	<script type="text/javascript" src="./js/jquery/js/jquery-ui-custom.min.js"></script>
	<!-- jQuery UI Combobox -->
	<link rel="stylesheet" href="./js/jquery/combobox.css">
	<script src="./js/jquery/combobox.js"></script>
	
	<!-- jQuery inits and other global stuff -->
	<script type="text/javascript" src="./js/logger.js?0331"></script>
	<script type="text/javascript" src="./js/localforage.min.js?0331"></script>
	<script type="text/javascript" src="./js/prepare-std.js?2329"></script>
	<script type="text/javascript" src="./js/DrawHistoryValue.js?0331"></script>
	<script type="text/javascript" src="./js/DrawHistoryItem.js?0331"></script>
	<script type="text/javascript" src="./js/DrawHistory.js?0331"></script>
	<script type="text/javascript" src="./js/sortable.js?0331"></script>
	<script type="text/javascript" src="./js/random-org/key.js?0331"></script>
	<script type="text/javascript" src="./js/random-org/RandomApi.js?0331"></script>

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
	<script language="JavaScript" type="text/javascript">
	var eventHistorySaveUrl = '<?=MainMenu::getModuleUrl('event_history', 'save')?>'.replace(/&amp;/g, '&');
	</script>
</head>
<body>
	<div class="not-supported-browser">
		<div class="ui-widget">
			<div class="ui-state-error ui-corner-all" style="margin: 1em; padding: 0 .7em;">
				<p>
					<span class="ui-icon ui-icon-alert"
						style="float: left; margin-right: .3em;"></span>
					Uwaga! Twoja przeglądarka jest przestarzała i nie jest wspierana (niektóre elementy mogą być dziwnie wyświetlane lub nie działać wcale).
				</p>
				<p>
					Zaktualizuj swoją przeglądarkę lub zainstaluj inną. 
					Możesz np. zainstalować darmową przeglądarkę <a href="https://www.mozilla.org/pl/firefox/" target="_blank">Mozilla Firefox</a>.
				</p>
			</div>
		</div>
	</div>
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
			<p>Copyright &copy;2014-2019 Maciej Jaros</p>
		</div>

		<div id="randomApi-verify-dialog" title="Weryfikacja losowania" style="display: none">
			<p>Numer kolejny losowania: <span data-id="serialNumber"></span></p>
			<p>Zakres losowania: <span data-id="min"></span>-<span data-id="max"></span></p>
			<p>Wylosowane liczby: <span data-id="result"></span></p>
			<form action='https://api.random.org/verify' method='post' target="_blank">
				<input type='hidden' name='format' value='json' />
				<input type='hidden' name='random' value='' />
				<input type='hidden' name='signature' value='' />
				<input type='submit' value='Sprawdź na Random.org' />
			</form>
		</div>
		<div id="history-prepare-dialog" title="Przygotowywanie historii" style="display: none">
			<p>Trwa przygotowywanie historii. Proszę czekać.</p>
			<p>Jeśli komunikat nie zniknie - sprawdź połączenie z Internetem
				i odśwież stronę lub skontaktuj się z administratorem.</p>
		</div>
		<div id="history-delete-dialog" title="Skasować historię działań?" style="display: none">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
				Kopia historii zostanie zapisana na serwerze, ale nie będziesz mógł(-a) jej przywrócić historii.</p>
			<p>Czy na pewno chcesz usunąć całą historię działań?</p>
			<ul data-id="buttons" style="display: none">
				<li data-id="delete">Skasuj historię</li>
				<li data-id="cancel">Anuluj</li>
			</ul>
		</div>
	</div>
</body>
</html>