<?php

namespace ColdTrick\LoginByEmail;

/**
 * Changes to views
 */
class Views {
	
	/**
	 * Change some view vars for the login form
	 *
	 * @param \Elgg\Event $event 'view_vars', 'input/form'
	 *
	 * @return null|array
	 */
	public static function loginFormVars(\Elgg\Event $event): ?array {
		$vars = $event->getValue();
		if (elgg_extract('action_name', $vars) !== 'login') {
			return null;
		}
		
		if (get_input('classic_login')) {
			return null;
		}
		
		// change the action
		$vars['action'] = elgg_generate_action_url('login_by_email/request_link', [], false);
		
		// remove ajax class
		$class = elgg_extract_class($vars);
		$key = array_search('elgg-js-ajax-form', $class);
		if ($key !== false) {
			unset($class[$key]);
		}
		
		$vars['class'] = $class;
		
		return $vars;
	}
}
