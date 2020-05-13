<?php


namespace App\Service;


class PurchasesDataAccess extends DataAccess
{
    public function getAllUserPurchases($id)
    {
        return parent::executeSQL("SELECT * FROM purchases WHERE user_id = :id ORDER BY date;", [
            "id" => $id,
        ])->fetchAll();
    }

    public function getPackage($id)
    {
        return parent::executeSQL("SELECT * FROM package WHERE id = :id;", [
            "id" => $id,
        ])->fetchAll();
    }

    public function registerUserPurchase($user_id, $package_id, $comics)
    {
        $success1 = $this->addPurchasePackage($package_id, $comics);
        $success2 = $this->addUserPurchase($user_id, $package_id);
        return $success1 and $success2;
    }

    private function addUserPurchase($user_id, $package_id)
    {
        return parent::executeSQL("INSERT INTO purchases (user_id, package_id, date) 
                                            VALUES (:id, :packageId, :date);", [
            "id" => $user_id,
            "packageId" => $package_id,
            "date" => date("H:i:s"),
        ]);
    }

    private function addPurchasePackage($package_id, $comics)
    {
        foreach ($comics as $comic) {
            parent::executeSQL("INSERT INTO package (id, comic_id, amount) 
                                            VALUES (:id, :comic_id, :amount);", [
                "id" => $package_id,
                "comic_id" => $comic["id"],
                "amount" => $comic["amount"],
            ]);
        }
    }
}