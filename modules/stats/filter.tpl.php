<!-- filtr -->
<style>
#search,#search-info {
	border-bottom: 1px solid #a8d2e3;
	margin-bottom: 1em;
}
#search-info p {
	margin: 0;
	padding: 0 1em 1em;
	font-style: italic;
}
#search {
	padding: 0 0 1em;
}

</style>
<?php if (empty($tplData['grupy_liczniki'])) { ?>
<div id="search-info">
	<p>Brak group do wyboru.</p>
</div>
<?php } else { ?>
<form id="search" method="post" action="">
	<div class="buttonset" style="float:left">
		<?php foreach ($tplData['grupy_liczniki'] as $i=>$row) { ?>
			<?php $grupa = $row['nazwa']; ?>
			<input id="grupa_<?=$i?>" type="checkbox" name="grupa[]" value="<?=$grupa?>"
					   <?=in_array($grupa, $tplData['prev']['grupa']) ? 'checked' : ''?>
				   >
			<label for="grupa_<?=$i?>"><?=$grupa?> (<?=$row['licznik']?>)</label>
		<?php } ?>
	</div>
	<div style="float:left; margin-left: 1em">
		<input type="submit" name="search" value="Zmień" />
	</div>
	<br clear="all" />
</form>
<?php } ?>
