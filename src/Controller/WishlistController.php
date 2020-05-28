<?php


namespace App\Controller;


use App\Service\ComicDataAccess;
use App\Service\WishlistDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return $this->redirectToRoute('listWishlist');
    }

    /**
     * @Route("/user/wishlist",  name="listWishlist")
     * @return Response
     */
    public function listWishlist(WishlistDataAccess $wishlistDataAccess, ComicDataAccess $comicDataAccess) {
        $user_id = $this->getUser()->getId();
        $items = $wishlistDataAccess->getUserWishlist($user_id);

        $comics = [];
        $i = 0;
        foreach($items as $item) {
            $comic = $comicDataAccess->getComicById($item['comic_id']);
            $comics[$i] = [
                'comic' => $comic,
            ];
            $i++;
        }
        return $this->render('public/wishlist.html.twig', [
            'comics' => $comics,
            'userId' => $user_id,
        ]);
    }


    /**
     * @Route("user/wishlist/remove", methods={"POST"}, name="removeFromWishList")
     * @return Response
     */
    public function removeFromWishList(WishlistDataAccess $wishlistDataAccess, Request $request) {
        $success = false;
        if($request->request->has("comicId")){
            $success = $wishlistDataAccess->deleteItemFromWishList($request->request->get("userId"),
                $request->request->get("comicId"));
        }
        return new JsonResponse(json_encode($success));
    }
}

