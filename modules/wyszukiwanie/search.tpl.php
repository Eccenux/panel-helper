<style type="text/css">
	form#search > div {
		display: table-row;
		margin:1em 1em 1em 0;
	}
	form#search > div > div {
		display: table-cell;
		padding: .5em;
	}
	form#search > div > label {
		font-weight:bold;
		display: table-cell;
		width: 120px;
		text-align: right;
		vertical-align: top;
		padding: 1em .5em;
		box-sizing: border-box;
	}
	form#search [name="search"] {
		margin-left: 127px;
		margin-top: 1.5em;
		padding: .5em 3em;
	}
</style>
<form id="search" method="post" action="">
	<div>
		<label>Miejsce zamieszkania</label>
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
		<label>Wiek</label>
		<div>
			od: <input type="number" name="wiek_od" min="16" max="100"
					   value="<?=$tplData['prev']['wiek_od']?>"
					   >
			do: <input type="number" name="wiek_do" min="16" max="100"
					   value="<?=$tplData['prev']['wiek_do']?>"
					   >
			<p style="margin:.5em 0 0 0">
			albo wybierz:
			<span class="wiek presets">
				<button>16-24</button>
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
			<input id="wyksztalcenie_<?=$i?>" type="checkbox" name="wyksztalcenie[]" value="<?=$row['wyksztalcenie']?>"
					   <?=in_array($row['wyksztalcenie'], $tplData['prev']['wyksztalcenie']) ? 'checked' : ''?>
				   >
			<label for="wyksztalcenie_<?=$i?>"><?
			switch ($row['wyksztalcenie'])
			{
				 case 'p': echo "podstawowe"; break;
				 case 's': echo "średnie"; break;
				 case 'w': echo "wyższe"; break;
				 default:
					echo $row['wyksztalcenie'];
				 break;
			} ?> (<?=$row['licznik']?>)</label>
		<? } ?>
		</div>
	</div>
	<input type="submit" name="search" value="Szukaj" />
</form>

<div style="margin-top: 2em">
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
			unset($row['id']);
		}
		ModuleTemplate::printArray($tplData['profiles']);
	}
?>
<script>
	// quick&evil
	var grupaSelectorUrl = '<?=MainMenu::getModuleUrl('edit', 'grupa')?>'.replace(/&amp;/g, '&');
	$('.grupa-selectors input').click(
		function (e) {
			var profileId = $(this).attr('name').replace(/[^0-9]+([0-9]+).*/, '$1');
			$.ajax(grupaSelectorUrl, {'data':{
				'grupa' : $(this).val(),
				'display' : 'raw',
				'id': profileId
			}})
			.done(function(data) {
				if (console && console.log) {
					console.log("Info:", data, "Id:", profileId);
				}
			})
			.fail(function(ajaxCall) {
				console.warn(arguments);
				alert("Błąd!\n\n" + ajaxCall.responseText);
			})
			;
			e.preventDefault();
		}
	);
</script>
</div>
