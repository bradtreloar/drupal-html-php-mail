<?php

namespace Drupal\html_php_mail\Plugin\Mail;

use Drupal\Core\Mail\Plugin\Mail\PhpMail;
use Drupal\Core\Mail\MailFormatHelper;

/**
 * Provides a 'HtmlFormatterMail' mail plugin.
 *
 * @Mail(
 *  id = "html_formatter_mail",
 *  label = @Translation("Html formatter mail"),
 *  description = @Translation("Sends the message as HTML text, using PHP's native mail() function.")
 * )
 */
class HtmlFormatterMail extends PhpMail {


  /**
   * {@inheritdoc}
   */
  public function format(array $message) {
    // Wrap each body section in a div while joining them into one string.
    $body = "";
    foreach($message['body'] as $section) {
      $body .= "<div>$section</div>";
    }

    $message['body'] = $body;

    return $message;
  }
}
