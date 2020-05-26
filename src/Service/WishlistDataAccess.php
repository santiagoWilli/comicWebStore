<?php


namespace App\Service;


class WishlistDataAccess extends DataAccess
{
    public function addToWishlist($userId, $comicId) {
        return parent::executeSQL("INSERT INTO wishlist (comic_id, user_id) 
                                        VALUES (:comic_id, :user_id);", [
            "comic_id" => $comicId,
            "user_id" => $userId,
        ]);
    }

    public function getUserWishlist($id) {
        return parent::executeSQL("SELECT * FROM wishlist WHERE user_id = :id;", [
            "id" => $id
        ])->fetchAll();
    }
}