<?php

namespace Drupal\html_php_mail\Plugin\Mail;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Mail\Plugin\Mail\PhpMail;

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
  public function format(array $message): array {

    if ($message['module'] == 'contact') {
      // @var \Drupal\contact\Entity\Message $contact_message
      $contact_message = $message['params']['contact_message'];

      $variables = [
        'fields' => [
          'Name' => $contact_message->getSenderName(),
          'Message' => $contact_message->getMessage(),
        ],
      ];

      // Set the MIME type for the message.
      $message['headers']['Content-Type'] = 'text/html; charset=UTF-8; format=flowed; delsp=yes';

      // Replace message body with fields.
      $template_file = drupal_get_path('module', 'html_php_mail') . '/templates/html-php-mail.html.twig';
      $twig_service = \Drupal::service('twig');
      $body = $twig_service->loadTemplate($template_file)->render($variables);
      $message['body'] = new FormattableMarkup($body, []);
    }
    else {
      $message = parent::format($message);
    }

    return $message;
  }
}
