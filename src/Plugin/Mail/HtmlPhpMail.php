<?php

namespace Drupal\html_php_mail\Plugin\Mail;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Mail\Plugin\Mail\PhpMail;

/**
 * Provides a 'HtmlPhpMail' mail plugin.
 *
 * @Mail(
 *  id = "html_php_mail",
 *  label = @Translation("PHP mailer with HTML content"),
 *  description = @Translation("Sends the message as HTML text, using PHP's native mail() function.")
 * )
 */
class HtmlPhpMail extends PhpMail {

  /**
   * {@inheritdoc}
   */
  public function format(array $message): array {

    // Set the MIME type for the message.
    $message['headers']['Content-Type'] = 'text/html; charset=UTF-8; format=flowed; delsp=yes';

    $elements = [
      'body' => implode("\n\n", $message['body']),
    ];

    // Render the message body with the active theme.
    $body = \Drupal::service('theme.manager')->render('html_php_mail', $elements);
    $message['body'] = $body;

    return $message;
  }
}
