<?php


namespace App\Controller;


use App\Service\UserDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     * @return Response
     */
    public function users(UserDataAccess $dataAccess) {
        $users = $dataAccess->getAllUsers();

        return $this->render('users.html.twig', [
            "userList" => $users,
        ]);
    }
}