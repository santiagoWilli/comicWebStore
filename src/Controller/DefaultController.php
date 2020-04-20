<?php


namespace App\Controller;


use App\Service\UserDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     * @throws Exception
     */
    public function index(UserDataAccess $dataAccess)
    {
        return $this->render('base.html.twig', [
        ]);
    }
}