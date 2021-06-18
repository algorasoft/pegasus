<?php
namespace app\models;

use algorasoft\garden\Model;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 *
 * Class ContactForm
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package app\models
 */

class ContactForm extends Model {

    public string $subject = '';
    public string $email   = '';
    public string $body    = '';

    public function rules(): array{
        return [
            'subject' => [self::RULE_REQUIRED],
            'email'   => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'body'    => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array{
        return [
            'subject' => 'Enter your subject',
            'email'   => 'Your email',
            'body'    => 'Message',
        ];
    }

    public function send() {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->IsSMTP();
            $mail->SMTPDebug     = SMTP::DEBUG_SERVER;
            $mail->SMTPAuth      = true;
            $mail->SMTPKeepAlive = true;
            $mail->Host          = '';
            $mail->Port          = 465;
            $mail->Username      = '';
            $mail->Password      = '';
            $mail->SMTPSecure    = 'ssl';

            //Recipients
            $mail->setFrom('no-reply@druprr.com', 'GARDEN Framework');
            $mail->addAddress('tmtinteractive@gmail.com', 'Danny Ngobo'); //Add a recipient

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            $mail->AltBody = $this->body;

            if ($mail->send()) {
                return true;
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}