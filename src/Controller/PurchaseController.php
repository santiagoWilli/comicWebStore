<?php

namespace App\Controller;

use App\Forms\Model\Payment;
use App\Forms\Type\PaymentType;
use App\Service\PurchasesDataAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController {

    /**
     * @Route("/payment", name="payment")
     * @return Response
     */
    /**public function payment(PurchasesDataAccess $dataAccess, Request $request) {
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
    }*/

}
