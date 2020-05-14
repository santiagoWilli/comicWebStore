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
     */
    public function payment(PurchasesDataAccess $dataAccess, Request $request) {
        $form = $this->createForm(PaymentType::class, new Payment());
        $price = $request->request->get("price") * $request->request->get("amount");

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $success = $dataAccess->addPurchase();

            if($success) {
                $this->addFlash('success', "¡Compra realizada con éxito!");
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('warning', "Ha ocurrido un error");
            }
        }

        return $this->render('public/payment.html.twig', [
            'form' => $form->createView(),
            'price' => $price,
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
