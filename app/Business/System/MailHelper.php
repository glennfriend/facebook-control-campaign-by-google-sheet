<?php
namespace App\Business\System;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class MailHelper
{

    public static function send($message, $type='Success')
    {
        $subject = "[{$type}] Facebook Campaign by Google Sheet";
        self::_send($subject, $message);
    }

    /* --------------------------------------------------------------------------------
        private
    -------------------------------------------------------------------------------- */

    private static function _send($subject, $body)
    {
        $mail = new Message;
        $mail
            ->setFrom('System <system@localhost.com>')
            ->setSubject($subject)
            ->setBody($body);

        foreach (conf('notify_emails') as $email) {
            $mail->addTo($email);
        }

        $mailer = new SendmailMailer;
        $mailer->send($mail);
    }

}

