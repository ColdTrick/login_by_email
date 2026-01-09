<?php

use ColdTrick\LoginByEmail\Controllers\Confirm;
use Elgg\Router\Middleware\LoggedOutGatekeeper;
use Elgg\Router\Middleware\SignedRequestGatekeeper;

return [
	'plugin' => [
		'version' => '1.0',
	],
	'settings' => [
		'code_validity' => 5,
	],
	'actions' => [
		'login_by_email/code' => ['access' => 'logged_out'],
		'login_by_email/request_link' => ['access' => 'logged_out'],
	],
	'routes' => [
		'default:login_by_email:code' => [
			'path' => 'login_by_email/code',
			'resource' => 'login_by_email/code',
			'middleware' => [
				LoggedOutGatekeeper::class,
			],
			'walled' => false,
		],
		'default:login_by_email:confirm' => [
			'path' => 'login_by_email/confirm/{guid}',
			'controller' => Confirm::class,
			'middleware' => [
				SignedRequestGatekeeper::class,
				LoggedOutGatekeeper::class,
			],
			'walled' => false,
		],
	],
	'events' => [
		'register' => [
			'menu:login' => [
				'\ColdTrick\LoginByEmail\Menus\Login::removePasswordReset' => [],
				'\ColdTrick\LoginByEmail\Menus\Login::register' => [],
			],
		],
		'view_vars' => [
			'input/form' => [
				'\ColdTrick\LoginByEmail\Views::loginFormVars' => [],
			],
		],
	],
];
