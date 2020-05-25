<?php


namespace App\Controller;


use App\Service\ComicDataAccess;
use App\Service\TagsDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    /**
     * @Route("/admin/tags", name="admin_tags")
     * @param ComicDataAccess $dataAccess
     * @return Response
     */

    public function comics(TagsDataAccess $dataAccess) {
        $tags = $dataAccess->getTags();

        return $this->render('admin/tags.html.twig', [
            "tags" => $tags,
        ]);
    }
}