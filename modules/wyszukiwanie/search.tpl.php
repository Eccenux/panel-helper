<? if ($tplData['wrong-group']) { ?>
<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em; margin-bottom: 1em;">
		<p>
			<span class="ui-icon ui-icon-alert"
				style="float: left; margin-right: .3em;"></span>
			Uwaga! W trakcie losowania należy wybrać grupę „w puli”. Wybierz z menu po lewej odpowiednią grupę przed rozpoczęciem losowania!
		</p>
	</div>
</div>
<? } ?>

<script src="modules/wyszukiwanie/DrawHelper.js?0331"></script>
<style type="text/css">
<?php include "search.css" ?>
</style>
<div class="draw-history-container">
	<h3>Historia działań</h3>
	<div class="draw-history">
	</div>
</div>
<div class="group-stats-container">
	<h3>Przydział do grup</h3>
	<ul class="group-stats">
		<? foreach (dbProfile::$pv_grupy as $g) { ?>
			<? foreach ($tplData['grupy_liczniki'] as $row) { ?>
				<? if ($g == $row['nazwa']) { ?>
					<li><?=$row['nazwa']?> (<?=$row['licznik']?>)</li>
				<? } ?>
			<? } ?>
		<? } ?>
	</ul>
</div>
<?php 
	if ($tplData['search-type'] === 'free') {
		include "search.free.tpl.php";
	} else {
		include "search.with-profile.tpl.php";
	}
?>

<?php /*
<textarea style="width: 100%; height: 30vh"><?=var_export($tplData, true)?></textarea>
<pre>prev: <?=var_export($tplData['prev'], true)?></pre>
<pre>search-submited: <?=var_export($tplData['search-submited'], true)?></pre>
*/?>

<section class="search-results">

<?php if (!empty($tplData['profiles']) && count($tplData['profiles']) > 6) { ?>
	<p><input type="button" name="draw6" value="Wylosuj 6 z listy" onclick="drawHelper.onDraw(this)" /></p>
<?php } ?>

<?php
	// quick&evil ;-)
	$grupaSelectorIndex = 1;
	function grupaSelector($current, $profileId)
	{
		global $grupaSelectorIndex;
		$html = '<div class="buttonset grupa-selectors">';
		$current = empty($current) ? 'w puli' : $current;
		foreach (dbProfile::$pv_grupy as $g)
		{
			$grupaSelectorIndex++;
			$html .= '<input type="radio" name="grupa-selector['.$profileId.']" id="grupa-selector-'.$grupaSelectorIndex.'" value="'.$g.'" '
				.($g==$current ? 'checked' : '')
				.'><label for="grupa-selector-'.$grupaSelectorIndex.'">'.$g.'</label>'
			;
		}
		$html .= '</div>';
		return $html;
	}
	if (!empty($tplData['profiles']))
	{
		foreach($tplData['profiles'] as $i=>&$row) {
			$row = array('l.p.'=>$i+1) + $row;
			$row['grupa'] = grupaSelector($row['grupa'], $row['id']);
			$row['ankieta_id'] = "<span class='profile-id-{$row['id']}'>{$row['ankieta_id']}</span>";
			unset($row['id']);
		}
		ModuleTemplate::printArray($tplData['profiles'], array(
			'ankieta_id' => 'ID ankiety',
			'plec' => 'płeć',
			'wyksztalcenie' => 'wykształcenie',
		), array(
			'wyksztalcenie' => function($value) {
				return dbProfile::pf_wyksztalcenieTranslate($value);
			},
		));
	}
?>

</section>

<script>
	// quick&evil
	var grupaSelectorUrl = '<?=MainMenu::getModuleUrl('edit', 'grupa')?>'.replace(/&amp;/g, '&');
	$('.grupa-selectors input').click(
		function (e) {
			var profileId = $(this).attr('name').replace(/[^0-9]+([0-9]+).*/, '$1');
			var grupName = $(this).val();
			var registrationId = $('.profile-id-'+profileId).text();
			drawHistory.saveGroupChange(grupName, registrationId, profileId);
			
			$.ajax(grupaSelectorUrl, {'data':{
				'grupa' : grupName,
				'display' : 'raw',
				'id': profileId
			}})
			.done(function(data) {
				if (console && console.log) {
					console.log("Info:", data, "Id:", profileId);
				}
			})
			.fail(function(ajaxCall) {
				if (console && console.warn) {
					console.warn(arguments);
				}
				alert("Błąd!\n\n" + ajaxCall.responseText);
			})
			;
			e.preventDefault();
		}
	);
</script>
