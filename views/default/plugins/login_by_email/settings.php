<?php

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('login_by_email:settings:code_validity'),
	'#help' => elgg_echo('login_by_email:settings:code_validity:help'),
	'name' => 'params[code_validity]',
	'value' => $plugin->code_validity,
	'min' => 1,
]);
