<h2>Historia działań z serwera</h2>
<?php if (!empty($tplData['history'])) { ?>
<p>Pokazuję historę o UUID: <?=$tplData['history']['uuid']?>,
	ostatnia zmiana: <?=$tplData['history']['dt_change']?>.</p>
<?php } ?>
<div class="draw-history draw-history-full"></div>
<p><input type="button" name="history-not-current" value="Pokaż nie-bieżącą" /></p>
<script>
// append currently displayed to the list of exception and reload
var currentUuid = '<?=$tplData['history']['uuid']?>';
$('[name="history-not-current"]').click(function(){
	var previousExceptions = "";
	var baseLocation = location.href.replace(/&uuid=[^&]*/, '').replace(/&not_uuid=([^&]*)/, function(a, previous) {
		previousExceptions = previous;
		return "";
	});
	location.href = baseLocation + '&not_uuid=' + (previousExceptions ? previousExceptions + "," : "") + currentUuid
});

// server history for JS
window.serverHistoryData = [];
<?php if (!empty($tplData['history'])) { ?>
	window.serverHistoryData = JSON.parse(<?=json_encode($tplData['history']['history_data'])?>);
<?php } ?>
</script>