<?php

namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
//use App\Entity\Contact;
//use App\Entity\ContactPro;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailService{
	
	private $mailer;
	private $MY_EMAIL;
	
	public function __construct($MY_EMAIL, MailerInterface $mailer){
		$this->mailer = $mailer;
		$this->MY_EMAIL = $MY_EMAIL;
	}
	
	public function sendEmail($mail, $message){
		 $mail = (new TemplatedEmail())
            ->from($mail)
            ->to($this->MY_EMAIL)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Formulaire Contact')
            ->text('Sending emails is fun again!')
            //->html('<p>Nouveau message du site : <br>'.$message.'</p>');
		
			// path of the Twig template to render
			->htmlTemplate('email/contact.email.twig')

    		// pass variables (name => value) to the template
    		->context([
				'mail' => $mail,
				'message' => $message,
			]);

        $this->mailer->send($mail);
	}
	
	public function sendMailPro($nom, $prenom, $sujet, $mail, $message, $userMail){
		$msg = (new TemplatedEmail())
            ->from($mail)
            ->to($userMail)
            ->subject($sujet)
			->htmlTemplate('email/contactPro.email.twig')
    		->context([
				'nom' => $nom,
				'prenom' => $prenom,
				'sujet' => $sujet,
				'mail' => $mail,
				'message' => $message,
			]);

        $this->mailer->send($msg);
	}
	
	public function sendToken(User $user){
		$mail = $user->getEmail();
		$msg = (new TemplatedEmail())
			->from($this->MY_EMAIL)
			->to($mail)
			->subject('Confirmation d\'inscription')
			->htmlTemplate('email/registerConfirm.email.twig')
			->context([
				'user' => $user
			]);
		$this->mailer->send($msg);
	}
}