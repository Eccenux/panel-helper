<? if (empty($pv_mainMenu)) { ?>
	<span class="empty">Menu jest puste</span>
<? } else { ?>
	<ul>
		<? foreach ($pv_mainMenu as $m) { ?>
			<? $isCurrentModule = ($pv_controller->moduleName === $m->moduleName) ?>
			<? if (empty($m->submenu)) { ?>
				<li class="leaf <?=($isCurrentModule ? 'current' : '')?>"><a href="<?=$m->url?>"><?=htmlspecialchars($m->title)?></a></li>
			<? } else { ?>
				<li class="branch <?=($isCurrentModule ? 'current' : '')?>"><a href="<?=$m->url?>"><?=htmlspecialchars($m->title)?></a>
					<ul>
						<? foreach ($m->submenu as $sm) { ?>
							<? $isCurrentAction = ($pv_controller->action === $sm['action']) ?>
							<li class="leaf <?=($isCurrentAction ? 'current' : '')?>"><a href="<?=$sm['url']?>"><?=htmlspecialchars($sm['title'])?></a></li>
						<? } ?>
					</ul>
				</li>
			<? } ?>
		<? } ?>
	</ul>
<? } ?>