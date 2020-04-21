<?php


namespace App\Controller;


use App\Entity\User;
use App\Forms\Type\CreateUserType;
use App\Service\UserDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/users/add", name="addUser")
     * @return Response
     */
    public function addUser(UserDataAccess $dataAccess, Request $request) {

        $form = $this->createForm(CreateUserType::class, new User());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->addUser($form->getData());

            if($success) {
                $this->addFlash('success', "Creado!");
                return $this->redirectToRoute('users');
            } else {
                $this->addFlash('warning', "Fallooooo!");
            }
        }

        return $this->render('userForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}