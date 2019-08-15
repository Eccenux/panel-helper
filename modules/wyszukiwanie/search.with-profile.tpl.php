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