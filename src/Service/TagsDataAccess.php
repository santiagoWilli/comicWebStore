<?php


namespace App\Service;


use App\Entity\Comic;

class TagsDataAccess extends DataAccess
{
    public function getTags() {
        return parent::executeSQL(
            "SELECT * FROM tags;"
        )->fetchAll();
    }
}
