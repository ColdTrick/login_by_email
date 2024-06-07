<?php
/**
 * Request a login link
 */

use Elgg\Values;

$username = get_input('username');
$returntoreferer = get_input('returntoreferer');

if (empty($username)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

// fetch the user (even disabled)
$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function () use ($username) {
	return elgg_get_user_by_username($username, true);
});
if (!$user instanceof \ElggUser) {
	return elgg_error_response(elgg_echo('login:baduser'), REFERRER, ELGG_HTTP_UNAUTHORIZED);
}

$site = elgg_get_site_entity();
$session = elgg_get_session();

$referer = $session->get('last_forward_from');
if (empty($referer) && !empty($returntoreferer)) {
	$referer = _elgg_services()->request->headers->get('Referer');
}

$code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

$code_validity = (int) elgg_get_plugin_setting('code_validity', 'login_by_email');

$session->set('login_by_email_code', $code);
$session->set('login_by_email_code_expires', Values::normalizeTimestamp("+{$code_validity} minutes"));
$session->set('login_by_email_referer', $referer);
$session->set('login_by_email_user_guid', $user->guid);

$link = elgg_generate_url('default:login_by_email:confirm', [
	'guid' => $user->guid,
	'r' => $referer,
]);
$link = elgg_http_get_signed_url($link, "+{$code_validity} minutes");

$subject = elgg_echo('login_by_email:notification:request_link:subject', [$site->getDisplayName()], $user->getLanguage());
$message = elgg_echo('login_by_email:notification:request_link:message', [
	$site->getDisplayName(),
	$link,
	$code,
], $user->getLanguage());

notify_user($user->guid, 0, $subject, $message, [], ['email']);

return elgg_ok_response('', elgg_echo('login_by_email:action:request_link:success'), elgg_generate_url('default:login_by_email:code'));
