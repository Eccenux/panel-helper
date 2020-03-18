<form id="search" method="post" action="" class="draw-history-profile-form">
<section class="free-search">
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
		<label>Region</label>
		<div>
			<select name="miejsce" class="combobox" data-keep-empty="1">
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
	<div>
		<label>Transport</label>
		<div class="buttonset">
		<? foreach ($tplData['transport'] as $i=>$row) { ?>
			<input id="transport_<?=$i?>" type="radio" name="transport" value="<?=$row['transport']?>"
						<?=($row['transport'] == $tplData['prev']['transport']) ? 'checked' : ''?>
					>
			<label for="transport_<?=$i?>"><?=$row['transport']?>
				(<?=$row['licznik']?>)</label>
		<? } ?>
			<input id="transport_i" type="radio" name="transport" value=""
					   <?=empty($tplData['prev']['transport']) ? 'checked' : ''?>
				   >
			<label for="transport_i">ignoruj  </label>
		</div>
	</div>
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
