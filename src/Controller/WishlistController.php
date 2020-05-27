<?php


namespace App\Controller;


use App\Service\WishlistDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WishlistController extends AbstractController
{
    /**
     * @Route("/user/wishlist/add", methods={"POST"}, name="addToWishlist")
     * @return Response
     */
    public function addToWishlist(WishlistDataAccess $dataAccess, Request $request) {
        $comicId = $request->request->get("comicId");
        $userId = $this->getUser()->getId();

        $dataAccess->addToWishlist($comicId, $userId);

        return $this->render('public/wishlist.html.twig');
    }
}