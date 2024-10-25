<?php

namespace Yohns\Security\FindingNemo;

use Yohns\Core\Config;

/*
 * !!	 $in_form = bin2hex('WHATT'.$bytes.'WHATT');
 * !!	 $bytes = random_bytes(32);
 *~!!	 echo 'bytes = '.$bytes.PHP_EOL;
 * !!	 echo 'bin(bytes = '.bin2hex($bytes).PHP_EOL;
 * !!	 echo 'bin(SALT1.bytes.SALT2 = '.$in_form.PHP_EOL;
 * !!	 echo PHP_EOL.'I put the last one in the form..
 *#!!	 so I receive the last line ^^ in $_POST'.PHP_EOL;
 *#!!	 echo 'Bytes is still the cariable, and I put that in my session..'.PHP_EOL;
 *-!!	 echo 'Now check that session with the above form porst..'.PHP_EOL;
 *?!	 echo '$_POST = '.$bytes.' and the $_POST = '.$in_form.PHP_EOL
 *?!!	 .' and now I convery my session = '.PHP_EOL;
 **!!	 echo bin2hex('WHATT'.$bytes.'WHATT');
**/

/**
 * Class Hash
 *
 * This class is responsible for handling the generation of secure tokens
 * for form submissions, as well as managing their validation and session
 * storage.
 */
class Hash {

	private $salty;
	private $ses_key = 'NemoTokes';

	/**
	 * Set the salt value used for token generation.
	 *
	 * @param string $sa The salt value to set.
	 * @return self Returns the current instance for method chaining.
	 */
	public function setsalt($sa): self {
		$this->salty = $sa;
		return $this;
	}

	/**
	 * Get the current salt value. If not set, it retrieves a default salt from configuration.
	 *
	 * @return string The current salt value.
	 */
	public function getsal(): string {
		if (!isset($this->salty) || $this->salty == '') {
			$this->setsalt(Config::get('salt', 'nemo'));
		}
		return $this->salty;
	}

	/**
	 * Set the session key used for storing tokens.
	 *
	 * @param string $sa The session key to set.
	 * @return self Returns the current instance for method chaining.
	 */
	public function settoke(string $sa): self {
		$this->ses_key = $sa;
		return $this;
	}

	/**
	 * Get the current session key.
	 *
	 * @return string The current session key.
	 */
	public function gettoke(): string {
		return $this->ses_key;
	}

	/**
	 * Generate a secure form token for a given form ID and store it in the session.
	 *
	 * @param string $form_id The unique identifier for the form.
	 * @return string The generated token for the form.
	 */
	public function form(string $form_id): string {
		$t = time();
		$bytes = random_bytes(32);
		$compact = $this->compact($form_id, $bytes);
		$this->gc();
		$_SESSION[$this->gettoke()][$form_id][$t]['token1'] = $compact['bytes'];
		$_SESSION[$this->gettoke()][$form_id][$t]['token2'] = $compact['form'];
		$this->gc();
		return $compact['form'];
	}

	/**
	 * Cleans up expired form tokens from the session.
	 *
	 * Tokens older than one hour are removed to prevent misuse.
	 *
	 * @return bool Returns false if no tokens were found to clean.
	 */
	private function gc(): bool {
		if (!$_SESSION[$this->gettoke()]) {
			return false;
		}
		$hourAgo = time() - (60 * 60);
		$forms = array_keys($_SESSION[$this->gettoke()]);
		foreach ($forms as $form_id) {
			$times = array_keys($_SESSION[$this->gettoke()][$form_id]);
			foreach ($times as $ti) {
				if ($ti < $hourAgo) {
					unset($_SESSION[$this->gettoke()][$form_id][$ti]); // Remove expired token
				}
			}
		}
		return false;
	}

	/**
	 * Validates a submitted token against stored tokens for a given form ID.
	 *
	 * @param string $form_id The unique identifier for the form.
	 * @param string $post The token submitted via the form.
	 * @return bool Returns true if the token is valid; otherwise false.
	 */
	public function valid(string $form_id,string $post): bool {
		if (isset($_SESSION[$this->gettoke()])) {
			if (isset($_SESSION[$this->gettoke()][$form_id]) && is_array($_SESSION[$this->gettoke()][$form_id])) {
				$loop = $_SESSION[$this->gettoke()][$form_id];
				//$time_keys = array_keys($loop);
				//$token1 = array_column($loop, 'token1');
				$token2 = array_column($loop, 'token2');
				if (in_array($post, $token2)) {
					// should I check if its correct? I kind of think its ok like this..
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Compact method to generate the combined token and its byte representation.
	 *
	 * This function combines the salt, form ID, and random bytes into a secure token format.
	 *
	 * @param string $form_id The unique identifier for the form.
	 * @param string $bytes The random bytes generated for security.
	 * @return array An associative array containing the secure form and bytes.
	 */
	private function compact(string $form_id, string $bytes): array {
		$salt = $this->getsal();
		$wbytes = bin2hex($bytes);
		$wform = bin2hex($salt . $form_id . $salt . $wbytes . $salt);
		return ['form' => $wform, 'bytes' => $wbytes];
	}
}
