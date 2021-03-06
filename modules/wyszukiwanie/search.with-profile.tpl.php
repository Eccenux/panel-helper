<script>
	var search_profiles = <?= json_encode($tplData['search_profiles'])?>;
	var selected_profile_id = <?= intval($tplData['selected_profile_id'])?>;
</script>
<form id="search" method="post" action="" class="draw-history-profile-form">
	<section class="profile-chooser">
		<div>
			<label>Profil</label>
			<select name="profil" class="combobox">
				<!--
				<option selected
						value="1">(1) m., PRZ. WIE. 25-39, w.</option>
				-->
			</select>
			<p>
				<button class="profil-prev" data-icon="triangle-1-w">Poprzedni</button>
				<button class="profil-next" data-icon-right="triangle-1-e">Następny</button>
			</p>
		</div>
	</section>
	<!-- fill profile selector etc -->
	<script>
		<?php include "search.with-profile.js" ?>
	</script>

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
						data-longValue='{$displayValue}'
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
		<?php if (empty($tplData['selected_profile_row'])) { ?>
			<p>Wybierz profil.</p>
		<?php } else { ?>
			<?=search_valueOrIgnore($tplData, "Płeć", "plec", $tplData['selected_profile_row']['sex'])?>

			<?=search_valueOrIgnore($tplData, "Region", "miejsce", $tplData['selected_profile_row']['region'])?>

			<?=search_valueOrIgnore($tplData, "Wiek", "wiek", $tplData['selected_profile_row']['age_range'])?>
			<input type="hidden" name="wiek_od" data-value="<?=$tplData['selected_profile_row']['age_min']?>">
			<input type="hidden" name="wiek_do" data-value="<?=$tplData['selected_profile_row']['age_max']?>">
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
							ageFrom.value = ageFrom.getAttribute('data-value');
							ageTo.value = ageTo.getAttribute('data-value');
						}
						console.log(`hidden age: ${ageFrom.value}, ${ageTo.value}`);
					}
					$('#search [name=wiek]').change(setupHiddenAge);
					// pre-init hidden
					setupHiddenAge();
				})();
			</script>

			<?=search_valueOrIgnore($tplData, "Wykształcenie", "wyksztalcenie"
					, $tplData['selected_profile_row']['education'], $tplData['selected_profile_row']['education_long'])?>

			<?=search_valueOrIgnore($tplData, "Transport", "transport", $tplData['selected_profile_row']['transport'])?>

			<?php /* var_export($tplData['selected_profile_row']) */ ?>
		<?php } ?>
	</section>

	<?php if (!empty($tplData['selected_profile_row'])) { ?>
	<section class="main-buttons">
		<button type="submit" name="search" value="search" data-icon="search">Szukaj</button>
		<button type="reset" class="reset-button" data-icon="refresh">Wyczyść opcje i odśwież</button>
	</section>
	<?php } ?>
</form>
<script>
$("form#search .reset-button").click(function(){
	location.href = location.search;
});
</script>