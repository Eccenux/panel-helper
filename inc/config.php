<?php

	/*
		Stages:
		# tests -- everything is accessible. Note! You are advised to anonimize data at this stage.
		# draw -- searching and editing is accessible.
		# results -- listing is unlocked, but editing is locked.
	*/
	define ('PANEL_STAGE', 'tests');

	if ($_SERVER['HTTP_HOST'] != 'localhost') {
		define ('REQUIRE_SECURE_CONNECTION', true);
	}
