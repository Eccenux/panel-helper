<h2>Historia działań z serwera</h2>
<p>Pokazuję historę o UUID: <?=$tplData['history']['uuid']?>,
	ostatnia zmiana: <?=$tplData['history']['dt_change']?>.</p>
<div class="draw-history draw-history-full"></div>
<p><input type="button" name="history-not-current" value="Pokaż nie-bieżącą"
		  onclick="location.href = location.href.replace(/&uuid=[^&]*/, '') + '&uuid=' + drawHistory.historyId" /></p>
<script>
window.serverHistoryData = [];
<?php if (!empty($tplData['history'])) { ?>
	window.serverHistoryData = JSON.parse(<?=json_encode($tplData['history']['history_data'])?>);
<?php } ?>
</script>