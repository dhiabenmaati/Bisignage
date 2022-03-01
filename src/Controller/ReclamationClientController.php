<?php


namespace App\Controller;

use App\Entity\Reclamations;
use App\Entity\ReclamationAdmin;
use App\Form\ReponseAdminType;
use App\Form\ReclamationType;
use App\Repository\ReclamationsRepository;
use App\Repository\ReclamationAdminRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Doctrine\ORM\EntityManager;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Count;


class ReclamationClientController extends AbstractController
{


    /**
     * @param Reclamations $repository
     * @return Response
     * @Route ("/AfficheA" , name="AfficheA")
     */

    function Affiche(ReclamationsRepository $repository)
    {

        $reclamation = $repository->findAll();

        return $this->render('admin/user/aff.html.twig', ['reclamation' => $reclamation]);


    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/recla", name="recla")
     */



    function Add(Request $request)
    {

        $reclamations = new reclamations ();
        $form = $this->createForm(ReclamationType::class, $reclamations);
        $form->Add('Envoyer', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reclamations->setEtat(1);
            $newDate= new \DateTime('now');
            $reclamations->setDate($newDate);
            $em->persist($reclamations);
            $em->flush();
            return $this->redirectToRoute('AfficheA');

        }
        return $this->render('admin/user/Envoyer.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param ReclamationsRepository $repo
     * @return Response
     * @Route ("/reps", name="reps")
     */

    public function AfficheAdmin(ReclamationsRepository $repo)
    {

        $reclamations = $repo->findAll();

        return $this->render('admin/Reclamation/rep.html.twig', ['reclamations' => $reclamations]);


    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/repond" , name="repond")
     */

    function ReponseAdmin(Request $request)
    {
        $id = $request->query->get('id');
        $reclamationAdmin = new reclamationAdmin ();
        $form = $this->createForm(ReponseAdminType::class, $reclamationAdmin);
        $form->add('Repondre', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation = $this->getDoctrine()->getRepository(Reclamations::class)->find($id);
            $reclamation->setEtat(2);
            $em = $this->getDoctrine()->getManager();
            $newDate= new \DateTime('now');
            $reclamationAdmin->setDate($newDate);
            $em->persist($reclamationAdmin);
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('reps');
        }
        return $this->render("admin/Reclamation/repondre.html.twig", array('form' => $form->createView()));

    }

    /**
     * @param ReclamationAdminRepository $repo
     * @return Response
     * @Route ("/Admin{id}", name="Admin")
     */

    public function AfficheReponse(ReclamationAdminRepository $repo, $id)
    {

        $reclamationAdmins = $repo->findAll();

       /** $em=$this->getDoctrine()->getRepository(ReclamationAdmin::class);
        $list=$em->findBy(array('reclamation'=>$id)); **/



        return $this->render('admin/user/AfficheReponse.html.twig', ['reclamationAdmins' => $reclamationAdmins]);


    }


    public function home()
    {


        return $this->render('base.html.twig');


    }


}
