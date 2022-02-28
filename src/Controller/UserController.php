<?php

namespace App\Controller;

use App\Entity\Admin\Comment;
use App\Entity\Admin\Shopping;
use App\Entity\Admin\User;
use App\Entity\Advertisment;
use App\Form\Admin\CommentType;
use App\Form\Admin\ShoppingType;
use App\Form\AdvertismentType;
use App\Form\User1Type;
use App\Form\UserType;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\ShoppingRepository;
use App\Repository\AdvertismentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('user/show.html.twig');
    }


    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //------------------Image Upload--------------//
            /** @var file $flie */
            $file = $form['image']->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // in Service.yaml defined images directory
                        $fileName
                    );
                } catch (FileException $e) {
                    //..handle exception if something happens during file upload
                }
                $user->setImage($fileName);
            }
            //------------------Image Upload--------------//
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, $id, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        if ($user->getId() != $id) {
            return $this->redirectToRoute('home');
        }



        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //------------------Image Upload--------------//
            /** @var file $flie */
            $file = $form['image']->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // in Service.yaml defined images directory
                        $fileName
                    );
                } catch (FileException $e) {
                    //..handle exception if something happens during file upload
                }
                $user->setImage($fileName);
            }
            //------------------Image Upload--------------//

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    // video advertisment

    /**
     * @Route("/advertisment", name="advertisment_index", methods={"GET"})
     */
    public function video_ads_index(AdvertismentRepository $advertismentRepository): Response
    {
        $id = $this->getUser()->getId();
        return $this->render('advertisment/index.html.twig', [
            'advertisments' => $advertismentRepository->findBy(array('user_id' => $id))
        ]);
    }

    /**
     * @Route("/advertisment/new", name="advertisment_new", methods={"GET","POST"})
     */
    public function video_ads_new(Request $request): Response
    {
        $advertisment = new Advertisment();
        $form = $this->createForm(AdvertismentType::class, $advertisment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //------------------Image Upload--------------//
            /** @var file $flie */
            $file = $form['image']->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // in Service.yaml defined images directory
                        $fileName
                    );
                } catch (FileException $e) {
                    //..handle exception if something happens during file upload
                }
                $advertisment->setVideoId($fileName);
            }
            //------------------Image Upload--------------//

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($advertisment);
            $entityManager->flush();

            return $this->redirectToRoute('advertisment_index');
        }

        return $this->render('advertisment/new.html.twig', [
            'advertisment' => $advertisment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/advertisment/{id}", name="advertisment_show", methods={"GET"})
     */
    public function video_ads_show(Advertisment $advertisment): Response
    {
        return $this->render('advertisment/show.html.twig', [
            'advertisment' => $advertisment,
        ]);
    }

    /**
     * @Route("/advertisment/{id}/edit", name="advertisment_edit", methods={"GET","POST"})
     */
    public function video_ads_edit(Request $request, Advertisment $advertisment): Response
    {
        $form = $this->createForm(AdvertismentType::class, $advertisment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //------------------Image Upload--------------//
            /** @var file $flie */
            $file = $form['image']->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), // in Service.yaml defined images directory
                        $fileName
                    );
                } catch (FileException $e) {
                    //..handle exception if something happens during file upload
                }
                $advertisment->setVideoId($fileName);
            }
            //------------------Image Upload--------------//

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('advertisment_index');
        }

        return $this->render('advertisment/edit.html.twig', [
            'advertisment' => $advertisment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/advertisment/{id}", name="advertisment_delete", methods={"DELETE"})
     */
    public function video_ads_delete(Request $request, Advertisment $advertisment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$advertisment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($advertisment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('advertisment_index');
    }

    // paypal payment
    /**
     * @Route("/payment", name="user_payment", methods={"GET"})
     */
    public function payment(): Response
    {
        return $this->render('user/payment.html.twig');
    }



    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}
