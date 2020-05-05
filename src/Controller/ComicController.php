<?php


namespace App\Controller;


use App\Entity\Comic;
use App\Forms\Type\CreateComicType;
use App\Service\ComicDataAccess;
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
     * @Route("/listcomics", name="listcomics")
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

        return $this->render('comics.html.twig', [
            "comicList" => $comics,
            "images" => $images,
        ]);
    }

    /**
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
}
