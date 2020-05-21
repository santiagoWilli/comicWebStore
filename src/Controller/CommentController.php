<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CommentsDataAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    /**
     * @Route("/public/listcomments", name="listComments")
     * @param CommentsDataAccess $dataAccess
     * @return Response
     */
    public function comments(CommentsDataAccess $dataAccess) {

        /*

        $comments = $dataAccess->getAllComics();

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
        ]);*/
    }


    /**
     * @Route("/public/addcomment", methods={"POST"}, name="addComment")
     * @return Response
     */
    public function addComment(CommentsDataAccess $dataAccess, Request $request){

        $iduser = $this->getUser()->getId();
        $idcomic = $request->request->get('id-comic');
        $comment = $request->request->get('comment');
        $success = $dataAccess->addComment($iduser, $idcomic, $comment);

        if($success) {
            $this->addFlash('success', "¡Creado!");
            return $this->redirectToRoute('comicInfo');
        } else {
            $this->addFlash('warning', "Error al crear comentario");
        }

    }

}