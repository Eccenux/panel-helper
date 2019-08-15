<? if ($tplData['wrong-group']) { ?>
<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
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
<form id="search" method="post" action="" class="draw-history-profile-form">
	<section class="profile-chooser">
		<div class="ui-widget">
			<label>Profil</label>
			<select name="profil" class="combobox">
				<option selected
						value="1">(1) m., CHE., 25-39, w.</option>
			</select>
		</div>
		<!-- TODO: wypełnianie `option` wg faktycznych profili (w JS, czy w PHP?) -->
		<!-- TODO: po wybraniu profilu wypełnianie `profile-options` 
			(mogę zrobić z przeładowaniem strony; to nie będę potrzebował danych profili w JS) -->
	</section>

	<?php
		/**
		 * Select or ignore search template.
		 */
		function search_valueOrIgnore(&$tplData, $label, $name, $value, $displayValue=null) {
			if (is_null($displayValue)) {
				$displayValue = $value;
			}

			$ignore = false;
			if ($tplData['search-submited']) {
				if (empty($tplData['prev'][$name])) {
					$ignore = true;
				}
			}

			return "
				<label>{$label}</label>
				<div class='buttonset'>
					<input type='radio' name='{$name}' id='{$name}_value' value='{$value}' 
						".(!$ignore ? 'checked' : '')."
						><label for='{$name}_value'>{$displayValue}</label>
					<input type='radio' name='{$name}' id='{$name}_ignore' value=''
						".($ignore ? 'checked' : '')."
						><label for='{$name}_ignore'>ignoruj  </label>
				</div>
			"
			;
		}
	?>
	<section class="profile-options">
		<?=search_valueOrIgnore($tplData, "Płeć", "plec", "mężczyzna", "Mężczyzna")?>

		<?=search_valueOrIgnore($tplData, "Dzielnica", "miejsce", "CHEŁM")?>

		<?=search_valueOrIgnore($tplData, "Wiek", "wiek", "25-39")?>
		<input type="hidden" name="wiek_od" value="25">
		<input type="hidden" name="wiek_do" value="39">
		<script>
			// hidden age values synchronization with visual fields
			(function(){
				let ageFrom = document.querySelector('#search [name=wiek_od]');
				let ageTo = document.querySelector('#search [name=wiek_do]');
				function setupHiddenAge(){
					// visual field value
					let value = $('#search [name=wiek]:checked').val();
					// ignore
					if (value.length === 0) {
						ageFrom.value = "";
						ageTo.value = "";
					// reset
					} else {
						ageFrom.value = ageFrom.getAttribute('value');
						ageTo.value = ageTo.getAttribute('value');
					}
				}
				$('#search [name=wiek]').change(setupHiddenAge);
				// pre-init hidden
				setupHiddenAge();
			})();
		</script>

		<?=search_valueOrIgnore($tplData, "Wykształcenie", "wyksztalcenie", "w", "wyższe")?>
	</section>

	<?php /*
	<div>
		<label>Płeć</label>
		<div class="buttonset">
			<input type="radio" name="plec" id="plec_m" value="mężczyzna"
				   <?=($tplData['prev']['plec']=='mężczyzna') ? 'checked' : ''?>
				   ><label for="plec_m">mężczyzna</label>
			<input type="radio" name="plec" id="plec_k" value="kobieta"
				   <?=($tplData['prev']['plec']=='kobieta') ? 'checked' : ''?>
				   ><label for="plec_k">kobieta  </label>
			<input type="radio" name="plec" id="plec_i" value=""
				   <?=(empty($tplData['prev']['plec'])) ? 'checked' : ''?>
				   ><label for="plec_i">ignoruj  </label>
		</div>
	</div>
	<div>
		<label>Dzielnica</label>
		<div>
			<select name="miejsce">
				<option value="">dowolna (&mdash;)</option>
				<? foreach ($tplData['miejsce'] as $row) { ?>
					<option <?=($tplData['prev']['miejsce']==$row['miejsce']) ? 'selected' : ''?>
						value="<?=$row['miejsce']?>"><?=$row['miejsce']?> (<?=$row['licznik']?>)</option>
				<? } ?>
			</select>
		</div>
	</div>
	<div>
		<label>Wiek</label>
		<div>
			od: <input type="number" name="wiek_od" min="18" max="100"
					   value="<?=$tplData['prev']['wiek_od']?>"
					   >
			do: <input type="number" name="wiek_do" min="18" max="100"
					   value="<?=$tplData['prev']['wiek_do']?>"
					   >
			<p style="margin:.5em 0 0 0">
			albo wybierz:
			<span class="wiek presets">
				<button>18-24</button>
				<button>25-39</button>
				<button>40-64</button>
				<button>65+</button>
				<button>ignoruj</button>
			</span>
			<script>
				$('.wiek.presets button').click(
					function (e) {
						var text = $(this).text();
						$('[name=wiek_od],[name=wiek_do]').val('');
						text.replace(/^[0-9]+/, function (number){
							$('[name=wiek_od]').val(number);
						});
						text.replace(/[^0-9]([0-9]+)/, function (a, number){
							$('[name=wiek_do]').val(number);
						});
						e.preventDefault();
					}
				);
			</script>
			</p>
		</div>
	</div>
	<div>
		<label>Wykształcenie</label>
		<div class="buttonset">
		<? foreach ($tplData['wyksztalcenie'] as $i=>$row) { ?>
			<input id="wyksztalcenie_<?=$i?>" type="radio" name="wyksztalcenie" value="<?=$row['wyksztalcenie']?>"
						data-longValue="<?=dbProfile::pf_wyksztalcenieTranslate($row['wyksztalcenie'])?>"
						<?=($row['wyksztalcenie'] == $tplData['prev']['wyksztalcenie']) ? 'checked' : ''?>
					>
			<label for="wyksztalcenie_<?=$i?>"><?=dbProfile::pf_wyksztalcenieTranslate($row['wyksztalcenie'])?>
				(<?=$row['licznik']?>)</label>
		<? } ?>
			<input id="wyksztalcenie_i" type="radio" name="wyksztalcenie" value=""
					   <?=empty($tplData['prev']['wyksztalcenie']) ? 'checked' : ''?>
				   >
			<label for="wyksztalcenie_i">ignoruj  </label>
		</div>
	</div>
	*/?>

	<section class="main-buttons">
		<button type="submit" name="search" value="search" data-icon="search">Szukaj</button>
		<button type="reset" class="reset-button" data-icon="refresh">Wyczyść opcje i odśwież</button>
	</section>
</form>
<script>
$("form#search .reset-button").click(function(){
	location.href = location.search;
});
</script>

<?php /*
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
