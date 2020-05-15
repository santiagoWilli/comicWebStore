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

    public function updateShoppingCart($userId, $comicId, $amount) {
        return parent::executeSQL("UPDATE shopping_cart SET amount = :amount
                                        WHERE comic_id = :comic_id AND user_id = :user_id;", [
            "comic_id" => $comicId,
            "user_id" => $userId,
            "amount" => $amount,
        ]);
    }

    public function getItemWithIdFromUserWithId($comicId, $userId) {
        return parent::executeSQL("SELECT * FROM shopping_cart WHERE user_id = :user_id 
                                     AND comic_id = :comic_id;", [
            "comic_id" => $comicId,
            "user_id" => $userId,
        ])->fetch();
    }

    public function deleteItemFromShoppingCart($user_id, $comic_id) {
        return parent::executeSQL("DELETE FROM shopping_cart WHERE comic_id = :comicId AND user_id = :userId;", [
            "comicId" => $comic_id,
            "userId" => $user_id,
        ]);
    }

    public function clearShoppingCart($user_id) {
        return parent::executeSQL("DELETE FROM shopping_cart WHERE user_id = :userId;", [
            "userId" => $user_id,
        ]);
    }
}