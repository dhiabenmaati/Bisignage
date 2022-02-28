<?php

namespace App\Controller\Home;

use App\Entity\Admin\Messages;
use App\Entity\Admin\Product;
use App\Form\Admin\MessagesType;
use App\Form\ContactType;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\ImageRepository;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( SettingRepository $settingRepository)
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/contact-us", name="contact")
     */
    public function contactus(Request $request,\Swift_Mailer $mailer): Response
    {
        $form= $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $message = (new \Swift_Message('Nouveau Contact'))
                ->setFrom($contact['email'])
                ->setTo('pisquad.piart@gmail.com')
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig', compact('contact')
                    ),'text/html'
                );
            $mailer->send($message);
            $this->addFlash('message','Le message a bien été envoyé');
        }
        return $this->render('home/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about( SettingRepository $settingRepository)
    {
        return $this->render('home/aboutus.html.twig');
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing( SettingRepository $settingRepository)
    {
        return $this->render('home/pricing.html.twig');
    }


}
