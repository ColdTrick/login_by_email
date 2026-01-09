<?php

namespace ColdTrick\LoginByEmail\Menus;

use Elgg\Menu\MenuItems;

/**
 * Make changes to the login menu
 */
class Login {
	
	/**
	 * Remove the password reset item from the menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:login'
	 *
	 * @return null|MenuItems
	 */
	public static function removePasswordReset(\Elgg\Event $event): ?MenuItems {
		if (get_input('classic_login')) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result->remove('forgotpassword');
		
		return $result;
	}
	
	/**
	 * Register menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:login'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (elgg_get_current_route_name() !== 'default:login_by_email:code') {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'login',
			'text' => elgg_echo('login_by_email:menu:login:new_request'),
			'href' => elgg_generate_url('account:login'),
		]);
		
		return $result;
	}
}
