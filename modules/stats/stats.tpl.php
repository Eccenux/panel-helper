<?php
	$currentRoot = dirname(__FILE__);
	require_once $currentRoot.'/filter.tpl.php';
?>

<!-- tableki -->
<div>
	<?php
			foreach($tplData['stats'] as $statName=>$stats) {
				echo "<div style='float:left;margin-right:1em'>";
				ModuleTemplate::printArray($stats);
				echo "</div>";
				if (empty($stats)) {
					break;
				}
			}
	?>
	<br clear="all"/>
</div>
