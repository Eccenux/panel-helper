<h2>Import profili</h2>

<h3>Zaimportowane dane</h3>
<?php if (empty($tplData['profile-summary'])) { ?>
<p>Brak</p>
<?php } else { ?>
Liczba profili:
<ul>
	<?php foreach ($tplData['profile-summary'] as $stat) { ?>
		<li><?=$stat['group_name']?>: <?=$stat['profiles']?></li>
	<?php } ?>
</ul>
<?php } ?>

<h3>Nowe dane</h3>

<?php if (!empty($tplData['parserInfo'])) { ?>
	<?=$tplData['parserInfo']?>

	<?php if (!empty($tplData['parser-rows'])) { ?>
		<?php if (!empty($tplData['parser-rows']['INVALID'])) { ?>
			<h3>Niepoprawne dane</h3>
			<?php ModuleTemplate::printArray($tplData['parser-rows']['INVALID'])?>
		<?php } ?>
		<?php if (!empty($tplData['parser-rows']['WARNING'])) { ?>
			<h3>Częściowo niepoprawne dane</h3>
			<?php ModuleTemplate::printArray($tplData['parser-rows']['WARNING'])?>
		<?php } ?>
	<?php } ?>

	<p><input type="button" onclick="location.href=location.href" value="Wróć" /></p>
<?php } else { ?>
	<form id="import-form" method="post" action="" enctype="multipart/form-data">
		<?php include 'import.form.tpl.php'; ?>
		<section class="buttons">
			<input type="submit" name="save" value="Importuj" />
		</section>
	</form>
<?php } ?>
