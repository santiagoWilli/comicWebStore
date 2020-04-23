<?php


namespace App\Controller;


use App\Entity\User;
use App\Forms\Type\CreateUserType;
use App\Service\UserDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $images = array();
        foreach ($users as $key => $user) {
            if ($user['profile_picture'] == null){
                $images[$key] = null;
                continue;
            }
            $images[$key] = base64_encode($user['profile_picture']);
        }

        return $this->render('users.html.twig', [
            "userList" => $users,
            "images" => $images,
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
                $this->addFlash('success', "¡Creado!");
                return $this->redirectToRoute('users');
            } else {
                $this->addFlash('warning', "Error al crear el usuario");
            }
        }

        return $this->render('userForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/users/delete", methods={"POST"}, name="deleteUser")
     * @return Response
     */
    public function deleteUser(UserDataAccess $dataAccess, Request $request) {
        $success = false;
        if($request->request->has("id")){
            $success = $dataAccess->deleteUser($request->request->get("id"));
        }
        return new JsonResponse(json_encode($success));
    }

}
