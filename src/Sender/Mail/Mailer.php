<?php

namespace Notification\Sender\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use function var_dump;

class Mailer implements MailInterface
{
    /**
     * @throws Exception
     */
    public function send($config, $params): void
    {

        $SMTPSecure = '';
        switch ($config['smtp']['SMTPSecure']) {
            case 'ENCRYPTION_STARTTLS':
                $SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                break;

            case 'ENCRYPTION_SMTPS':
                $SMTPSecure = PhpMailer::ENCRYPTION_SMTPS;
                break;
        }


        //Create an instance; passing `true` enables exceptions
        $mail = new PhpMailer(true);

        //Server settings
        $mail->isSMTP();
        $mail->Host       = $config['smtp']['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['smtp']['username'];
        $mail->Password   = $config['smtp']['password'];
        $mail->SMTPSecure = $SMTPSecure;
        $mail->Port       = $config['smtp']['port'];

        // Mail setting
        $mail->setFrom($config['from']['email'], $config['from']['name']);
        $mail->addAddress($params['to']['email'], $params['to']['name']);
        $mail->isHTML(true);
        $mail->Subject = $params['subject'];
        $mail->Body    = $params['body'];
        $mail->CharSet = 'UTF-8';
        $mail->send();
    }
}