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
        $idcomic = $request->request->get('comicId');
        $comment = $request->request->get('comment');
        $dataAccess->addComment($iduser, $idcomic, $comment);

        return $this->redirectToRoute('comicInfo',[
            "id" => $idcomic]);
    }

    /**
     * @Route("/public/editcomment", methods={"POST"}, name="editComment")
     * @return Response
     */
    public function editComment(CommentsDataAccess $dataAccess, Request $request){
        $iduser = $this->getUser()->getId();
        $idcomic = $request->request->get('comicId');
        $comment = $request->request->get('modifyComment');
        $dataAccess->editComment($iduser, $idcomic, $comment);

        return $this->redirectToRoute('comicInfo',[
            "id" => $idcomic]);
    }

    /**
     * @Route("/public/deleteComment", methods={"POST"}, name="deleteComment")
     * @return Response
     */
    public function deleteComment(CommentsDataAccess $dataAccess, Request $request){
        $iduser = $this->getUser()->getId();
        $idcomic = $request->request->get('comicId');
        $comment = $request->request->get('modifyComment');
        $dataAccess->deleteComment($iduser, $idcomic, $comment);

        return $this->redirectToRoute('comicInfo',[
            "id" => $idcomic]);
    }


}
