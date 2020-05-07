<?php


namespace App\Service;


class ShoppingCartAccess extends DataAccess
{
    public function getItemsFromUserWithId($id) {
        return parent::executeSQL("SELECT * FROM shopping_cart WHERE user_id = :id;", [
            "id" => $id
        ])->fetchAll();
    }
}