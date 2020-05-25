<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index()
    {
        return $this->render('public/index.html.twig', [
        ]);
    }

    /**
     * @Route("/administracion", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function admin_index()
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }
}
