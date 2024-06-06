<?php
/**
 * Elgg login form
 */

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('loginusername'),
	'name' => 'username',
	'autofocus' => true,
	'required' => true,
]);

if (get_input('classic_login')) {
	echo elgg_view_field([
		'#type' => 'password',
		'#label' => elgg_echo('password'),
		'name' => 'password',
		'required' => true,
		'autocomplete' => 'current-password',
	]);
}

echo elgg_view('login/extend', $vars);

if (isset($vars['returntoreferer'])) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'returntoreferer',
		'value' => 'true'
	]);
}

$footer = elgg_view_field([
	'#type' => 'fieldset',
	'#class' => 'elgg-justify-right',
	'fields' => [
		[
			'#type' => 'submit',
			'text' => elgg_echo('login'),
		],
	],
]);
$footer .= elgg_view_menu('login');
elgg_set_form_footer($footer);
