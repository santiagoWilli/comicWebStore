<?php


namespace App\Controller;


use App\Service\ComicDataAccess;
use App\Service\ShoppingCartAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/user/shoppingcart", name="listShoppingCart")
     * @return Response
     */
    public function listShoppingCart(ShoppingCartAccess $shoppingCartAccess, ComicDataAccess $comicDataAccess) {
        $items = $shoppingCartAccess->getItemsFromUserWithId($this->getUser()->getId());

        $comics = [];
        $i = 0;
        foreach($items as $item) {
            $comics[$i] = [
                'comic' => $comicDataAccess->getComicById($item['comic_id']),
                'amount'=> $item['amount']
            ];
            $i++;
        }
        return $this->render('public/shoppingCart.html.twig', [
            'comics' => $comics,
        ]);
    }
}