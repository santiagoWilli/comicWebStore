<?php


namespace App\Controller;


use App\Entity\Comic;
use App\Forms\Type\CreateComicType;
use App\Forms\Type\EditComicType;
use App\Service\ComicDataAccess;
use App\Service\CommentsDataAccess;
use App\Service\UserDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class ComicController extends AbstractController
{
    /**
     * @Route("/admin/listcomics", name="listComicsAsAdmin")
     * @param ComicDataAccess $dataAccess
     * @return Response
     */

    public function comics(ComicDataAccess $dataAccess) {
        $comics = $dataAccess->getAllComics();

        $images = array();
        foreach ($comics as $key => $comic) {
            if ($comic['image'] == null){
                $images[$key] = null;
                continue;
            }
            $images[$key] = base64_encode($comic['image']);
        }

        return $this->render('admin/comics.html.twig', [
            "comicList" => $comics,
            "images" => $images,
        ]);
    }

    /**88
     * @Route("/comics/delete", methods={"POST"}, name="deleteComic")
     * @return Response
     */
    public function deleteComic(ComicDataAccess $dataAccess, Request $request) {
        $success = false;
        if($request->request->has("id")){
            $success = $dataAccess->deleteComic($request->request->get("id"));
        }
        return new JsonResponse(json_encode($success));
    }

    /**
     * @Route("/comics/add", name="addComic")
     * @return Response
     */
    public function addComic(ComicDataAccess $dataAccess, Request $request) {

        $form = $this->createForm(CreateComicType::class, new Comic());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->addComic($form->getData());

            if($success) {
                $this->addFlash('success', "¡Creado!");
                return $this->redirectToRoute('listComicsAsAdmin');
            } else {
                $this->addFlash('warning', "Error al crear el comic");
            }
        }

        return $this->render('admin/addComicForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/comics", name="listComicsAsUser")
     * @param ComicDataAccess $dataAccess
     * @return Response
     */
    public function userComics(ComicDataAccess $dataAccess) {
        $comics = $dataAccess->getAllComics();

        $images = array();
        foreach ($comics as $key => $comic) {
            if ($comic['image'] == null){
                $images[$key] = null;
                continue;
            }
            $images[$key] = base64_encode($comic['image']);
        }

        return $this->render('public/comics.html.twig', [
            "comicList" => $comics,
            "images" => $images,
        ]);
    }

    /**
     * @Route("/comics/tags", name="comicTags")
     * @param ComicDataAccess $dataAccess
     * @return Response
     */
    public function comicsTags(ComicDataAccess $dataAccess) {
        $tags = $dataAccess->getTags();

        return $this->render('public/tags.html.twig', [
            "tags" => $tags,
        ]);
    }

    /**
     * @Route("/comics/tag/{tag}", name="comicWithTag")
     * @param ComicDataAccess $dataAccess
     * @return Response
     */
    public function comicsWithTag($tag, ComicDataAccess $dataAccess) {
        $comics = $dataAccess->getComicsWithTag($tag);

        $images = array();
        foreach ($comics as $key => $comic) {
            if ($comic['image'] == null){
                $images[$key] = null;
                continue;
            }
            $images[$key] = base64_encode($comic['image']);
        }

        return $this->render('public/comics.html.twig', [
            "comicList" => $comics,
            "images" => $images,
        ]);
    }

    /**
     * @Route("/comic/{id}", name="comicInfo")
     * @return Response
     */
    public function showComicInfo($id, ComicDataAccess $dataAccess, CommentsDataAccess $commentDataAccess, UserDataAccess $userDataAccess){
        $comic = $dataAccess->getComicById($id);
        $image = base64_encode($comic['image']);

        $comments = $commentDataAccess->getAllComicComments($id);
        $commentsUsers = array();

        if ($this->getUser() != null){
            $currentUserId = $this->getUser()->getId();
        } else{
            $currentUserId = -1;
        }

        $loggedUserComment = null;

        foreach($comments as $key => $comment){
            $userId = $comment['user_id'];
            if ($userId == $currentUserId){
                $loggedUserComment = $comment['comment'];
                unset($comments[$key]);
                continue;
            }
            $user = $userDataAccess->getUserById($userId);
            $user['profile_picture'] = base64_encode($user['profile_picture']);
            $commentsUsers[$key] = $user;
        }

        $genres = $dataAccess->getTagsFromComic($id);

        return $this->render('public/comicInfo.html.twig', [
            "comic" => $comic,
            "image" => $image,
            "genres" => $genres,
            "loggedUserComment" => $loggedUserComment,
            "comments" => $comments,
            "commentsUsers" => $commentsUsers,
        ]);
    }

    /**
     * @Route("/comics/edit/{id}", name="editComic")
     * @return Response
     */
    public function editComic($id, ComicDataAccess $dataAccess, Request $request) {

        $comic_array= $dataAccess->getComicById($id);
        $comic = new Comic($comic_array["title"], $comic_array["description"], $comic_array["price"],
            $comic_array["publisher"], $comic_array["genre"], $comic_array["release_date"], $comic_array["stock"],
            $comic_array["author"]);

        $form = $this->createForm(EditComicType::class, $comic);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->editComic($form->getData(), $id);

            if($success) {
                $this->addFlash('success', "¡Modificado!");
                return $this->redirectToRoute('listComicsAsAdmin');
            } else {
                $this->addFlash('warning', "Error al modificar el comic");
            }
        }

        return $this->render('admin/editComicForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
