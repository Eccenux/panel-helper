<h2>Historia działań z serwera</h2>
<?php if (!empty($tplData['history'])) { ?>
<p>Pokazuję historę o UUID: <?=$tplData['history']['uuid']?>,
	ostatnia zmiana: <?=$tplData['history']['dt_change']?>.</p>
	<div class="draw-history draw-history-full"></div>
<?php } else { ?>
	Brak danych do wyświetlania.
<?php } ?>
<p><input type="button" name="history-not-current" value="Pokaż nie-bieżącą" /></p>
<script>
// get currently displayed id
var currentUuid = '<?=(!empty($tplData['history']) ? $tplData['history']['uuid'] : '')?>';
// actions done after history is ready
function drawHistoryReadyChecks () {
	// if nothing is displayed and displaying specifc uuid => use current users history ID
	if (currentUuid.length == 0 && location.search.search(/&uuid=[^&]+/) >= 0) {
		currentUuid = drawHistory.historyId;
	}
	// if there is nothing to add to exceptions then hide the button
	if (currentUuid.length == 0) {
		$('[name="history-not-current"]').hide();
	}
}
if (drawHistory.historyId === null) {
	$(drawHistory).on("ready", drawHistoryReadyChecks);
} else {
	drawHistoryReadyChecks();
}
// append currently displayed to the list of exception and reload
$('[name="history-not-current"]').click(function(){
	var previousExceptions = "";
	var baseLocation = location.href.replace(/&uuid=[^&]*/, '').replace(/&not_uuid=([^&]*)/, function(a, previous) {
		previousExceptions = previous;
		return "";
	});
	location.href = baseLocation + '&not_uuid=' + (previousExceptions ? previousExceptions + "," : "") + currentUuid
});
</script>

<script>
// server history for JS
window.serverHistoryData = [];
<?php if (!empty($tplData['history'])) { ?>
	window.serverHistoryData = JSON.parse(<?=json_encode($tplData['history']['history_data'])?>);
<?php } ?>
</script>