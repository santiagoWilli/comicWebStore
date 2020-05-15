<?php

namespace App\Controller;

use App\Forms\Model\Payment;
use App\Forms\Type\PaymentType;
use App\Service\ComicDataAccess;
use App\Service\PurchasesDataAccess;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $amount = $request->request->get("amount");
        $comic_id = $request->request->get("comicId");
        $user_id = $this->getUser()->getId();

        $comics[0] = [
            'id' => $comic_id,
            'amount' => $amount,
        ];

        $clave = $comic_id . $user_id . random_int(0, PHP_INT_MAX);
        $package_id = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 13]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
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
            'comicId' => $comic_id,
        ]);
    }

    /**
     * @Route("/cartpayment", name="cartPayment")
     * @return Response
     * @throws \Exception
     */
    public function shoppingCartPayment(PurchasesDataAccess $dataAccess, Request $request) {
        $form = $this->createForm(PaymentType::class, new Payment());

        if ($request->request->get("firstStep") != null) {
            $comics = [];
            $i = 0;
            $comics_index = 0;
            while(true) {
                if (($checkbox = $request->request->get("checkbox-" . $i)) == null) break;
                dump($request);
                if ($checkbox === "on") {
                    $comic_id = $request->request->get("comic-" . $i);
                    $amount = $request->request->get("amount-" . $i);
                    $comics[$comics_index++] = [
                        'id' => $comic_id,
                        'amount' => $amount,
                    ];
                }
                $i++;
            }
        }

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comics = unserialize(base64_decode($request->request->get("comicId")));
            $clave = $comics[0]["id"] . $this->getUser()->getId() . random_int(0, PHP_INT_MAX);
            $package_id = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 13]);
            $success = $dataAccess->registerUserPurchase($this->getUser()->getId(), $package_id, $comics);
            if($success) {
                $this->addFlash('success', "¡Compra realizada con éxito!");
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
            $packages = $dataAccess->getPackage($purchase['package_id']);
            $purchaseComics = [];
            $j=0;
            foreach ($packages as $package){
                $purchaseComics[$j] = [
                    'comic' => $comicDataAccess->getComicById($package['comic_id']),
                    'amount' => $package['amount'],
                ];
                $j++;
            }
            $purchases[$i] = [
                'comics' => $purchaseComics,
                'id' => $purchase['package_id'],
                'date' => $purchase['date']
            ];
            $i++;
        }

        return $this->render('public/purchaseHistory.html.twig', [
            'purchases' => $purchases,
        ]);

    }



}
