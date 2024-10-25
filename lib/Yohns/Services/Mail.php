<?php
namespace Yohns\Services;

use Yohns\Core\Config;

/**
 * Class Mail
 *
 * This class is responsible for handling the composition and sending of emails.
 * It allows for setting various parameters such as the recipient, sender, reply-to address,
 * subject, message body, and more. The email can be sent in HTML format if specified.
 *
 * @package JW3B\Services
 */
class Mail {
	public string $to;
	public string $from       = '';
	public string $replyTo    = '';
	public string $subject;
	public string $msg;
	public string $btnLink    = '';
	public string $btnText    = '';
	public string $domain     = '';
	public string $unsubEmail = '';
	public string $template   = ''; //__DIR__ . '/MailTemplates/email.template.html';
	public string $tempDir		= ''; //__DIR__ . '/MailTemplates/';
	public bool   $useHTML    = true;
	public string $CC         = '';
	public string $BCC        = '';

	/**
	 * Mail constructor.
	 *
	 * Initializes the Mail object and sets the template location based on the configuration.
	 */
	public function __construct() {
		$mail = Config::getAll('mail');
		$this->template 	= $mail['dir'].'email.template.html';
		$this->tempDir		= $mail['default'];
		$this->from       = $mail['from'];
		$this->replyTo    = $mail['replyTo'];
		$this->btnLink    = $mail['btnLink'];
		$this->btnText    = $mail['btnText'];
		$this->domain     = $mail['domain'];
		$this->unsubEmail = $mail['unsubEmail'];
	}

	/**
	 * Sends the email using the specified headers and template.
	 *
	 * This method constructs the email headers based on the properties of this object.
	 * It reads the email template file, replaces placeholders with actual values,
	 * and sends the email using the mail() function.
	 *
	 * @return bool Returns true on success, false on failure.
	 */
	public function send(): bool {
		// To send HTML mail, the Content-type header must be set
		$headers = [
			'MIME-Version' => '1.0',
			'From'         => $this->getFrom(),
			'Reply-To'     => $this->getFrom(),
		];
		if ($this->useHTML === true) {
			$headers['Content-type'] = 'text/html; charset=iso-8859-1';
		} else {
			$headers['X-Mailer'] = 'PHP/' . phpversion();
		}
		if ($this->CC !== '') {
			$headers['Cc'] = $this->CC;
		}
		if ($this->BCC !== '') {
			$headers['Bcc'] = $this->BCC;
		}
		$file = file_get_contents($this->template);
		$find = [
			'[msg-title]', '[msg]', '[btn-link]', '[btn-text]', '[domain]', '[unsusbscribe-email]'
		];
		$replace = [
			$this->getSubject(), $this->getMsg(), $this->getBtnLink(), $this->getBtnText(), $this->getDomain(), $this->getUnsubEmail()
		];
		$message = str_replace($find, $replace, $file);
		return mail($this->to,
			$this->subject,
			$message,
			$headers);
	}

	/**
	 * Get the recipient email address.
	 *
	 * @return string The recipient email address.
	 */
	public function getTo(): string {
		return $this->to;
	}

	/**
	 * Set the recipient email address.
	 *
	 * @param string $to The recipient email address.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setTo(string $to): self {
		$this->to = $to;
		return $this;
	}

	/**
	 * Get the sender email address.
	 *
	 * @return string The sender email address.
	 */
	public function getFrom(): string {
		return (string) $this->from;
	}

	/**
	 * Set the sender email address.
	 *
	 * @param string $from The sender email address.
	 *  Mary <mary@example.com>
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setFrom(string $from): self {
		$this->from = $from;
		return $this;
	}

	/**
	 * Get the reply-to email address.
	 *
	 * @return string The reply-to email address.
	 */
	public function getReplyTo(): string {
		return (string) $this->replyTo;
	}

	/**
	 * Set the reply-to email address.
	 *
	 * @param string $replyTo The reply-to email address.
	 *  Mary <mary@example.com>
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setReplyTo(string $replyTo): self {
		$this->replyTo = $replyTo;
		return $this;
	}

	/**
	 * Get the subject of the email.
	 *
	 * @return string The subject of the email.
	 */
	public function getSubject(): string {
		return (string) $this->subject;
	}

	/**
	 * Set the subject of the email.
	 *
	 * @param string $subject The subject of the email.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setSubject(string $subject): self {
		$this->subject = $subject;
		return $this;
	}

	/**
	 * Get the message body of the email.
	 *
	 * @return string The message body of the email.
	 */
	public function getMsg(): string {
		return $this->msg;
	}

	/**
	 * Set the message body of the email.
	 *
	 * @param string $msg The message body of the email.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setMsg(string $msg): self {
		$this->msg = $msg;
		return $this;
	}

	/**
	 * Get the button link.
	 *
	 * @return string The URL for the button link.
	 */
	public function getBtnLink(): string {
		return $this->btnLink;
	}

	/**
	 * Set the button link.
	 *
	 * @param string $btnLink The URL for the button link.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setBtnLink(string $btnLink): self {
		$this->btnLink = $btnLink;
		return $this;
	}

	/**
	 * Get the button text.
	 *
	 * @return string The text to display on the button.
	 */
	public function getBtnText(): string {
		return $this->btnText;
	}

	/**
	 * Set the button text.
	 *
	 * @param string $btnText The text to display on the button.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setBtnText(string $btnText): self {
		$this->btnText = $btnText;
		return $this;
	}

	/**
	 * Get the domain name.
	 *
	 * @return string The domain name of the service.
	 */
	public function getDomain(): string {
		return $this->domain;
	}

	/**
	 * Set the domain name.
	 *
	 * @param string $domain The domain name of the service.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setDomain(string $domain): self {
		$this->domain = $domain;
		return $this;
	}

	/**
	 * Get the unsubscribe email address.
	 *
	 * @return string The unsubscribe email address.
	 */
	public function getUnsubEmail(): string {
		return $this->unsubEmail;
	}

	/**
	 * Set the unsubscribe email address.
	 *
	 * @param string $unsubEmail The unsubscribe email address.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setUnsubEmail(string $unsubEmail): self {
		$this->unsubEmail = $unsubEmail;
		return $this;
	}

	/**
	 * Get the flag indicating whether HTML is to be used.
	 *
	 * @return bool True if HTML should be used, false otherwise.
	 */
	public function getUseHTML(): bool {
		return $this->useHTML;
	}

	/**
	 * Set the flag indicating whether to use HTML for the email body.
	 *
	 * @param bool $useHTML True to use HTML, false otherwise.
	 * @return self Returns the current Mail instance for method chaining.
	 */
	public function setUseHTML(bool $useHTML): self {
		$this->useHTML = $useHTML;
		return $this;
	}

	/**
	 * Get the email template path.
	 *
	 * @return string The path to the email template.
	 */
	public function getTemplate(): string {
		return $this->template;
	}

	/**
	 * Set the email template path.
	 *
	 * This method sets the path to the specified template file.
	 * If the template file does not exist, an exception is thrown.
	 *
	 * @param string $template The name of the template file without the extension.
	 * @return self Returns the current Mail instance for method chaining.
	 * @throws \RuntimeException if the specified template file is not found.
	 */
	public function setTemplate(string $template): self {
		$temp = $this->tempDir.'/'.$template.'.html';
		if(is_file($temp)){
			$this->template = $this->tempDir.'/'.$template;
		} else {
			throw new \RuntimeException('Mail Template file not found.');
		}
		return $this;
	}
}