<?php


namespace App\Service;


class ShoppingCartAccess extends DataAccess
{
    public function getItemsFromUserWithId($id) {
        return parent::executeSQL("SELECT * FROM shopping_cart WHERE user_id = :id;", [
            "id" => $id
        ])->fetchAll();
    }

    public function addToShoppingCart($userId, $comicId, $amount) {
        return parent::executeSQL("INSERT INTO shopping_cart (comic_id, user_id, amount) 
                                        VALUES (:comic_id, :user_id, :amount);", [
            "comic_id" => $comicId,
            "user_id" => $userId,
            "amount" => $amount,
        ]);
    }
}