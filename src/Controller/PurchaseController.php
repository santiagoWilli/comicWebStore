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
     * @throws \Exception
     */
    /**public function payment(PurchasesDataAccess $dataAccess, Request $request) {
        $form = $this->createForm(PaymentType::class, new Payment());

        $comic_price = $request->request->get("price");
        $amount = $request->request->get("amount");
        $comic_id = $request->request->get("comicId");
        $user_id = $this->getUser()->getId();

        dump($amount);
        dump($comic_id);

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
            dump($success);
        }

        return $this->render('public/payment.html.twig', [
            'form' => $form->createView(),
            'price' => $comic_price * $amount,
            'amount' => $amount,
            'comicId' => $comic_id,
        ]);
    }*/

}
