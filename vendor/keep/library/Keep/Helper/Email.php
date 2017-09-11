<?php

namespace Keep\Helper;

class Email {

    private $email;
    private $sendgrid;

    public function __construct() {
        $this->sendgrid = new \SendGrid('chicosilva', 'ledro5478wer');
        $this->email = new \SendGrid\Email();
    }

    public function send($to, $subject, $html, $from = false) {

        if (!$from) {
            $from = _EMAIL_;
        }

        $this->email
                ->addTo($to)
                ->setFromName('FECOAGRO Leite Minas')
                ->setFrom($from)
                ->setSubject($subject)
                ->setText($html)
                ->setHtml($html);

        try {
            $this->sendgrid->send($this->email);
        } catch (Exception $ex) {
            
        }
    }

}


//
//
//
//
//
//
//
//
//
//
//
//
//
//<?php
//
//namespace Keep\Helper;
//
//use Zend\Mail;
//use Zend\Mail\Transport\Smtp as SmtpTransport;
//use Zend\Mail\Transport\SmtpOptions;
//
//class Email {
//
//    public function __construct() {
//        
//    }
//
//    public function send($to, $subject, $html, $from = false) {
//
//        if (!$from) {
//            $from = _EMAIL_;
//        }
//        
//        $options = new SmtpOptions(array(
//            "name" => "gmail",
//            "host" => "smtp.gmail.com",
//            "port" => 587,
//            "connection_class" => "plain",
//            "connection_config" => array(
//                "username" => "protheus.ccgc@ccgc.com.br",
//                "password" => "sistema1",
//                "ssl" => "tls")
//        ));
//
//
//        $bodyPart = new \Zend\Mime\Message();
//
//        $bodyMessage = new \Zend\Mime\Part($html);
//        $bodyMessage->type = 'text/html';
//
//        $bodyPart->setParts(array($bodyMessage));
//
//        $mail = new Mail\Message();
//        $mail->setBody($bodyPart);
//        $mail->setFrom($from, 'CCGC');
//        $mail->addTo($to, '');
//        $mail->setSubject($subject);
//
//        $transport = new SmtpTransport();
//        $transport->setOptions($options);
//        $transport->send($mail);
//    }
//
//}
