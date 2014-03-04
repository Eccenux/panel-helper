<div id="dane_kontaktowe_container">
	<?php
			foreach($tplData['stats'] as $statName=>$stats) {
				echo "<div style='float:left;margin-right:1em'>";
				ModuleTemplate::printArray($stats);
				echo "</div>";
			}
	?>
	<br clear="all"/>
</div>
