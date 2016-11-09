<p>
	Liczba osób w tej kategorii: <?=count($tplData['personal'])?>
</p>
<p>
	<input type="button" id="dane_kontaktowe_show" value="Pokaż dane kontaktowe" data-value-hide="Schowaj dane kontaktowe">
	<input type="button" id="dane_kontaktowe_export" value="Eksportuj telefony (CSV)">
	<input type="button" id="dane_id_export" value="Eksportuj id ankiet (CSV)">
</p>
<div id="dane_kontaktowe_container" style="float:left;">
	<?php
			foreach($tplData['personal'] as $i=>&$row) {
				$row['e_mail'] = "<span class='dane' style='display:none'>{$row['e_mail']}</span>";
				$row['nr_tel'] = "<span class='dane phone' style='display:none'>{$row['nr_tel']}</span>";
			}
			ModuleTemplate::printArray($tplData['personal'],
					array(
						'nazwisko_imie'=>'nazwisko, imię',
						'e_mail'=>'e-mail',
						'nr_tel'=>'telefon',
					)
			);
	?>
</div>
<div id="dane_id_container" style="float:left; margin-left: 5em">
	<?php
			ModuleTemplate::printArray($tplData['poll_ids'],
					array(
						'ankieta_id'=>'id',
					)
			);
	?>
</div>
<br clear="all">
<script src="js/export-csv.js"></script>
<script>
	grupa_ascii = '<?=$tplData['grupa_ascii']?>';
</script>
<script>
(function($){
	var $dane = $('#dane_id_container td');
	var $trigger = $('#dane_id_export');
	$trigger.click(function (e)
	{
		var numbers = [];
		$dane.each(function (){
			numbers.push([this.textContent]);
		});
		exportToCsv(grupa_ascii+'_id.csv', numbers);
	});
})(jQuery);
</script>
<script>
(function($){
	var $dane = $('#dane_kontaktowe_container .dane.phone');
	var $trigger = $('#dane_kontaktowe_export');
	$trigger.click(function (e)
	{
		var phoneNumbers = [];
		$dane.each(function (){
			phoneNumbers.push([this.textContent]);
		});
		exportToCsv(grupa_ascii+'_numery.csv', phoneNumbers);
	});
})(jQuery);
</script>
<script>
(function($){
	var hidden = true;
	var $dane = $('#dane_kontaktowe_container .dane');
	var $trigger = $('#dane_kontaktowe_show');
	var text = {
		show : $trigger.val(),
		hide : $trigger.attr('data-value-hide')
	};
	$trigger.click(
		function (e)
		{
			if (hidden) {
				if (confirm('Czy na pewno chcesz odkryć PRYWATNE dane?')) {
					$dane.show();
					hidden = false;
				}
			} else {
				$dane.hide();
				hidden = true;
			}
			if (hidden) {
				$trigger.val(text.show);
			} else {
				$trigger.val(text.hide);
			}
			e.preventDefault();
		}
	);
})(jQuery);
</script>
