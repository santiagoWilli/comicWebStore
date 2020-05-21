<?php

namespace App\Controller;

use App\Forms\Model\Payment;
use App\Forms\Type\PaymentType;
use App\Service\ComicDataAccess;
use App\Service\PurchasesDataAccess;
use App\Service\ShoppingCartAccess;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController {

    /**
     * @Route("/payment", name="payment")
     * @return Response
     * @throws \Exception
     */
    public function payment(PurchasesDataAccess $dataAccess, Request $request) {
        $form = $this->createForm(PaymentType::class, new Payment());

        $comic_price = $request->request->get("price");
        $user_id = $this->getUser()->getId();
        $amount = $request->request->get("amount");
        $comics = [];
        if ($request->request->get("firstStep") != null) {
            $comic_id = $request->request->get("comicId");
            $comics[0] = [
                'id' => $comic_id,
                'amount' => $amount,
            ];
        }

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comics = unserialize(base64_decode($request->request->get("comicId")));
            dump($comics);
            $clave = $comics[0]["id"] . $user_id . random_int(0, PHP_INT_MAX);
            $package_id = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 13]);
            $success = $dataAccess->registerUserPurchase($user_id, $package_id, $comics);
            if($success) {
                $this->addFlash('success', "¡Compra realizada con éxito!");
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('warning', "Ha ocurrido un error");
            }
        }

        return $this->render('public/payment.html.twig', [
            'form' => $form->createView(),
            'price' => $comic_price * $amount,
            'amount' => $amount,
            'comicId' => $comics,
        ]);
    }


    /**
     * @Route("/cartpayment/all", name="cartPaymentAll")
     * @return Response
     * @throws \Exception
     */
    public function shoppingCartPaymentAll(PurchasesDataAccess $purchasesDataAccess, ShoppingCartAccess $shoppingCartAccess, Request $request) {
        $form = $this->createForm(PaymentType::class, new Payment());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $cartItems = $shoppingCartAccess->getItemsFromUserWithId($this->getUser()->getId());
            $comics = [];
            $i = 0;
            foreach ($cartItems as $item) {
                $comics[$i++] = [
                    "id" => $item["comic_id"],
                    "amount" => $item["amount"],
                ];
            }

            $clave = $comics[0]["id"] . $this->getUser()->getId() . random_int(0, PHP_INT_MAX);
            $package_id = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 13]);
            $success = $purchasesDataAccess->registerUserPurchase($this->getUser()->getId(), $package_id, $comics);
            if($success) {
                $this->addFlash('success', "¡Compra realizada con éxito!");
                $shoppingCartAccess->clearShoppingCart($this->getUser()->getId());
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('warning', "Ha ocurrido un error");
            }
        }

        return $this->render('public/payment.html.twig', [
            'form' => $form->createView(),
            'price' => "",
            'amount' => "",
            'comicId' => "",
        ]);
    }



    /**
     * @Route("/cartpayment", name="cartPayment")
     * @return Response
     * @throws \Exception
     */
    public function shoppingCartPayment(PurchasesDataAccess $dataAccess, ShoppingCartAccess $shoppingCartAccess, Request $request) {
        $form = $this->createForm(PaymentType::class, new Payment());

        if ($request->request->get("firstStep") != null) {
            $comics = [];
            $i = 0;
            $comics_index = 0;
            $cartSize = sizeof($shoppingCartAccess->getItemsFromUserWithId($this->getUser()->getId()));
            for($i = 0; $i < $cartSize; $i++) {
                dump("checkbox-" . $i);
                if ($request->request->get("checkbox-" . $i) === "on") {
                    $comic_id = $request->request->get("comic-" . $i);
                    $amount = $request->request->get("amount-" . $i);
                    $comics[$comics_index++] = [
                        'id' => $comic_id,
                        'amount' => $amount,
                    ];
                }
            }
            dump($comics);
        }

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comics = unserialize(base64_decode($request->request->get("comicId")));
            dump($comics);
            $clave = $comics[0]["id"] . $this->getUser()->getId() . random_int(0, PHP_INT_MAX);
            $package_id = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 13]);
            $success = $dataAccess->registerUserPurchase($this->getUser()->getId(), $package_id, $comics);
            if($success) {
                $this->addFlash('success', "¡Compra realizada con éxito!");
                foreach ($comics as $comic) {
                    $shoppingCartAccess->deleteItemFromShoppingCart($this->getUser()->getId(), $comic["id"]);
                }
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('warning', "Ha ocurrido un error");
            }
        }

        return $this->render('public/payment.html.twig', [
            'form' => $form->createView(),
            'price' => 38,
            'amount' => "",
            'comicId' => $comics,
        ]);
    }


    /**
     * @Route("/purchase_history", name="purchaseHistory")
     * @return Response
     */
    public function purchaseHistory(PurchasesDataAccess $dataAccess, ComicDataAccess $comicDataAccess) {
        $userPurchases = $dataAccess->getAllUserPurchases($this->getUser()->getId());
        $purchases = [];
        $i=0;
        foreach ($userPurchases as $purchase){
            $purchases[$i] = [
                'id' => $purchase['package_id'],
                'date' => $purchase['date']
            ];
            $i++;
        }

        return $this->render('public/purchaseHistory.html.twig', [
            'purchases' => $purchases,
        ]);

    }


    /**
     * @Route("/purchase_history/package", methods={"POST"}, name="getPackage")
     * @return Response
     */
    public function getPackageComics(PurchasesDataAccess $dataAccess, ComicDataAccess $comicDataAccess, Request $request){
        $package = $dataAccess->getPackage($request->request->get('id-package'));
        $comics = [];
        $j=0;
        foreach ($package as $comic){
            $comics[$j] = [
                'comic' => $comicDataAccess->getComicById($comic['comic_id']),
                'amount' => $comic['amount'],
            ];
            $j++;
        }
        $data = [
            'content' => $this->renderView('public/packageTable.html.twig', [
                'comics' => $comics,
            ]),
        ];
        return new JsonResponse(json_encode($data));
    }

}
