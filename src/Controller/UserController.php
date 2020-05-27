<?php


namespace App\Controller;


use App\Entity\User;
use App\Forms\Type\CreateUserType;
use App\Forms\Type\EditProfileType;
use App\Service\UserDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="listUsersAsAdmin")
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

        return $this->render('admin/users.html.twig', [
            "userList" => $users,
            "images" => $images,
        ]);
    }

    /**
     * @Route("/admin/users/add", name="addUser")
     * @return Response
     */
    public function addUser(UserDataAccess $dataAccess, Request $request) {

        $form = $this->createForm(CreateUserType::class, new User());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->addUser($form->getData());

            if($success) {
                $this->addFlash('success', "¡Creado!");
                return $this->redirectToRoute('listUsersAsAdmin');
            } else {
                $this->addFlash('warning', "Error al crear el usuario");
            }
        }

        return $this->render('admin/addUserForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/users/delete", methods={"POST"}, name="deleteUser")
     * @return Response
     */
    public function deleteUser(UserDataAccess $dataAccess, Request $request) {
        $success = false;
        if($request->request->has("id")){
            $success = $dataAccess->deleteUser($request->request->get("id"));
        }
        return new JsonResponse(json_encode($success));
    }

    /**
     * @Route("/admin/users/edit/{id}", name="editUser")
     * @return Response
     */
    public function editUser($id, UserDataAccess $dataAccess, Request $request) {
        $user_array= $dataAccess->getUserById($id);

        $user = new User($user_array["name"], $user_array["last_name"], $user_array["role"],
            $user_array["password"], $user_array["email"], $user_array["birth_date"]);
        $user->setId($id);

        $user->setProfilePicture(null);

        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->editUser($form->getData());

            if($success) {
                $this->addFlash('success', "¡Modificado!");
                return $this->redirectToRoute('listUsersAsAdmin');
            } else {
                $this->addFlash('warning', "Error al modificar el usuario");
            }
        }

        return $this->render('admin/editUserForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/profile", name="viewProfile")
     * @return Response
     */
    public function viewProfile(){
        $user = $this->getUser();
        $image = base64_encode($user->getProfilePicture());
        return $this->render('public/userProfile.html.twig', [
            'user' => $user,
            'image' => $image,
        ]);
    }


    /**
     * @Route("/profile/edit", name="editProfile")
     * @return Response
     */
    public function editProfile(UserDataAccess $dataAccess, Request $request) {

        $user = $this->getUser();
        $user->setProfilePicture(null);

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->editUser($form->getData());

            if($success) {
                $this->addFlash('success', "¡Modificado!");
                return $this->redirectToRoute('viewProfile');
            } else {
                $this->addFlash('warning', "Error al modificar el usuario");
            }
        }

        return $this->render('public/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
