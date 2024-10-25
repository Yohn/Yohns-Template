<?php

namespace Yohns\Security;

/**
 * Class Honeypot
 *
 * This class implements a honeypot security measure that generates
 * random questions to distinguish between bots and human users.
 * The questions are designed to be simple and pose a challenge to
 * automated scripts. The responses are stored in the session for
 * validation purposes.
 */
class Honeypot {

	/**
	 * Randomly selects a type of question to ask from the available options.
	 *
	 * The options include mathematical operations and simple data prompts.
	 * This function invokes the selected question function and returns
	 * the result.
	 *
	 * @return array The randomly selected questions function within this is called.
	 */
	public function pick_pot(): array {
		$pots = ['add', 'sub', 'alpha_before', 'alpha_after', 'user_data'];
		$pick = array_rand($pots);
		$picked = $pots[$pick];
		return $this->$$picked();
	}

	/**
	 * Generates a simple addition question.
	 *
	 * This function creates two random integers between 0 and 6,
	 * sums them, and stores the result in the session. It returns
	 * an associative array containing the numbers used in the addition,
	 * along with labels for presentation.
	 *
	 * @return array An array with the information for the addition question.
	 */
	private function add(): array {
		// what is 3+5
		$one = rand(0, 6);
		$two = rand(0, 6);
		$_SESSION['Honeypot']['add'] = $one + $two;
		return [
			'add' => [
				'a' => $one,
				'b' => $two,
				'label' => 'Pop Quiz:',
				'label-ext' => $one.' + '.$two.' = '
			]
		];
	}

	/**
	 * Generates a simple subtraction question.
	 *
	 * This function generates two random integers, one between 6 and 10
	 * and the other between 1 and 5. It calculates their difference,
	 * stores the result in the session, and returns an array containing
	 * the values used in the subtraction along with corresponding labels.
	 *
	 * @return array An array with the information for the subtraction question.
	 */
	private function sub(): array {
		$one = rand(6, 10);
		$two = rand(1, 5);
		$_SESSION['Honeypot']['sub'] = $one - $two;
		return [
			'sub' => [
				'a' => $one,
				'b' => $two,
				'label' => 'Pop Quiz:',
				'label-ext' => $one.' - '.$two.' = '
			]
		];
	}

	/**
	 * Generates a question asking for the letter before a random letter.
	 *
	 * This function randomly selects a letter from B to Z and identifies
	 * the preceding letter. The result is saved in the session for validation.
	 * The function returns an array consisting of the selected letter and
	 * its predecessor, along with descriptive labels.
	 *
	 * @return array An array containing the selected letter and its predecessor.
	 */
	private function alpha_before(): array {
		$alph = range('B', 'Z');
		$letter = rand(0, 24);
		if($letter == 0){
			$before = 'A';
		} else {
			$before = $alph[$letter-1];
		}
		$_SESSION['Honeypot']['alpha-before'] = $before;
		return [
			'alpha-before' => [
				'l' => $alph[$letter],
				'a' => $before,
				'label' => 'Pop Quiz:',
				'label-ext' => 'Letter before '.$alph[$letter].' is:'
			]
		];
	}

	/**
	 * Generates a question asking for the letter after a random letter.
	 *
	 * This function randomly selects a letter from A to Y and identifies
	 * the subsequent letter. The result is saved in the session for validation
	 * purposes. The function returns an array with the selected letter and
	 * its successor, alongside descriptive labels.
	 *
	 * @return array An array containing the selected letter and its successor.
	 */
	private function alpha_after(): array {
		$alph = range('A', 'Y');
		$letter = rand(0, 24);
		if($letter == 24){
			$after = 'Z';
		} else {
			$after = $alph[$letter+1];
		}
		$_SESSION['Honeypot']['alpha-after'] = $after;
		return [
			'alpha-after' => [
				'l' => $alph[$letter],
				'a' => $after,
				'label' => 'Pop Quiz:',
				'label-ext' => 'Letter after '.$alph[$letter].' is:'
			]
		];
	}

	/**
	 * Generates a question asking for a type of user data.
	 *
	 * This function randomly selects one of three types of user information:
	 * username, email, or password. The selection is saved in the session.
	 * The function returns an array containing the selected user data type
	 * and a question prompt.
	 *
	 * @return array An array consisting of the selected user data type and prompt.
	 */
	private function user_data(): array {
		$which = ['username','email','password'];
		$r = array_rand($which);
		$w = $which[$r];
		$_SESSION['Honeypot']['user_data'] = $w;
		return [
			'user_data' => [
				'a' => $w,
				'label' => 'Pop Quiz:',
				'label-ext' => 'What is your '.$w.'?'
			]
		];
	}
}