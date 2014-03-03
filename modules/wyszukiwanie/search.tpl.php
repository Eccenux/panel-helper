<style type="text/css">
	form#search > div {
		margin:1em 1em 1em 0;
	}
	form#search > div > div {
		display: inline-block;
	}
	form#search > div > label {
		font-weight:bold;
		display: inline-block;
		width: 120px;
		text-align: right;
	}
	form#search [name="search"] {
		margin-left: 120px;
		margin-top: 1em;
	}
</style>
<form id="search" method="post" action="">
	<div>
		<label>Dzielnica</label>
		<div>
			<select name="dzielnica">
			<? foreach ($tplData['dzielnice'] as $row) { ?>
				<option <?=($tplData['prev']['dzielnica']==$row['dzielnica']) ? 'selected' : ''?>
					><?=$row['dzielnica']?></option>
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
			} ?></label>
		<? } ?>
		</div>
	</div>
	<div>
		<label>Dzieci</label>
		<div class="buttonset">
			<input type="radio" name="dzieci" id="dzieci_m" value="mam"
				   <?=($tplData['prev']['dzieci']=='mam') ? 'checked' : ''?>
				   ><label for="dzieci_m">ma</label>
			<input type="radio" name="dzieci" id="dzieci_n" value="nie mam"
				   <?=($tplData['prev']['dzieci']=='nie mam') ? 'checked' : ''?>
				   ><label for="dzieci_n">nie ma</label>
			<input type="radio" name="dzieci" id="dzieci_i" value=""
				   <?=(empty($tplData['prev']['dzieci'])) ? 'checked' : ''?>
				   ><label for="dzieci_i">ignoruj</label>
		</div>
	</div>
	<input type="submit" name="search" value="Szukaj" />
</form>

<div style="margin-top: 2em">
<?php
	if (!empty($tplData['profiles']))
	{
		ModuleTemplate::printArray($tplData['profiles']);
	}
?>
</div>
