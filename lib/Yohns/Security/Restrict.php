<?php

namespace Yohns\Security;


/**
 * Class Restrict
 *
 * This class provides methods to check and restrict the usage of disposable email addresses.
 * Disposable email addresses are often used for temporary purposes and might pose security risks.
 * https://github.com/disposable-email-domains/disposable-email-domains
 *
 * @source https://github.com/disposable-email-domains/disposable-email-domains
 */
class Restrict {

	/**
	 * Checks if the provided email address belongs to a disposable email domain.
	 *
	 * This method splits the email address into local and domain parts, then checks if the
	 * domain part is in the list of disposable email domains, which is sourced from
	 * a configuration file `disposable-emails.php`.
	 *
	 * @param string $email The email address to check for disposability.
	 * @return bool Returns true if the email domain is disposable and should be blocked,
	 *              otherwise returns false.
	 */
	public static function check($email) {
		$split = explode('@', strtolower($email));
		$list = include __DIR__ . '/disposable-emails.php';
		if (in_array($split[1], $list)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Determines if an email address is disposable based on a blocklist.
	 *
	 * This method retrieves disposable domains from a specified blocklist file or
	 * a default file if none is specified. It then checks if the domain of the given
	 * email address is within this list.
	 *
	 * @param string $email The email address to check for disposability.
	 * @param string|null $blocklist_path Optional path to a custom blocklist file.
	 * @return bool Returns true if the email domain is found in the blocklist,
	 *              otherwise returns false.
	 */
	public static function isDisposableEmail($email, $blocklist_path = null) {
		if (is_null($blocklist_path)) $blocklist_path = __DIR__ . '/disposable_email_blocklist.conf';
		$disposable_domains = file($blocklist_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$domain = mb_strtolower(explode('@', trim($email))[1]);
		return in_array($domain, $disposable_domains);
	}
}