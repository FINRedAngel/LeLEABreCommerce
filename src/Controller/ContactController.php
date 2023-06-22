<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Service\EmailSender;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['POST'])]
    public function index(HttpFoundationRequest $request, EmailSender $emailSender, LoggerInterface $logger): Response
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        $sucessMessage = null;

        if($form->isSubmitted() && $form->isValid()) {
            /** @var ContactForm $contactForm */
            $contactForm = $form->getData();

            try{
                $emailSender->sendContactForm($contactForm);
            } catch (TransportExceptionInterface $exception){
                $form->addError(new FormError('Could not send your request'));
                $logger->error('It was a problem sending email', [
                    'error' => $exception->getMessage(),
                ]);
            }

            $sucessMessage = 'Le message a été correctement envoyer!';
        }

        return $this->renderForm('widget/contact.html.twig', [
            'form' => $form,
            'successMessage' => $sucessMessage
        ]);
    }
}