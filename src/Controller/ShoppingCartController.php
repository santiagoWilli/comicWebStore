<?php


namespace App\Controller;


use App\Service\ComicDataAccess;
use App\Service\ShoppingCartAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/user/shoppingcart", name="listShoppingCart")
     * @return Response
     */
    public function listShoppingCart(ShoppingCartAccess $shoppingCartAccess, ComicDataAccess $comicDataAccess) {
        $user_id = $this->getUser()->getId();
        $items = $shoppingCartAccess->getItemsFromUserWithId($user_id);

        $comics = [];
        $i = 0;
        $total = 0;
        foreach($items as $item) {
            $comic = $comicDataAccess->getComicById($item['comic_id']);
            $comics[$i] = [
                'comic' => $comic,
                'amount'=> $item['amount']
            ];
            $total += $comic['price'] * $item['amount'];
            $i++;
        }
        return $this->render('public/shoppingCart.html.twig', [
            'comics' => $comics,
            'total' => $total,
            'userId' => $user_id,
        ]);

    }

    /**
     * @Route("/user/shoppingcart/add", methods={"POST"}, name="addToShoppingCart")
     * @return Response
     */
    public function addToShoppingCart(ShoppingCartAccess $shoppingCartAccess, Request $request) {
        $comicId = $request->request->get("comicId");
        $amount = $request->request->get("amount");
        $userId = $this->getUser()->getId();

        $item = $shoppingCartAccess->getItemWithIdFromUserWithId($comicId, $userId);

        if (!empty($item)) {
            $amount += $item["amount"];
            $shoppingCartAccess->updateShoppingCart($userId, $comicId, $amount);
        } else {
            $shoppingCartAccess->addToShoppingCart($userId, $comicId, $amount);
        }

        return $this->redirectToRoute('listShoppingCart');
    }

    /**
     * @Route("user/shoppingcart/remove", methods={"POST"}, name="removeFromShoppingCart")
     * @return Response
     */
    public function removeFromShoppingCart(ShoppingCartAccess $shoppingCartAccess, Request $request) {
        $success = false;
        if($request->request->has("comicId")){
            $success = $shoppingCartAccess->deleteItemFromShoppingCart($request->request->get("userId"),
                                                                       $request->request->get("comicId"));
        }
        return new JsonResponse(json_encode($success));
    }
}

