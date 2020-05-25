<?php


namespace App\Service;


class CommentsDataAccess extends DataAccess
{
    public function getAllComicComments($id)
    {
        return parent::executeSQL("SELECT * FROM comments WHERE comic_id = :id ORDER BY date;", [
            "id" => $id,
        ])->fetchAll();
    }

    public function addComment($user_id, $comic_id, $comment)
    {
        return parent::executeSQL("INSERT INTO comments (user_id, comic_id, comment, date) 
                                            VALUES (:id, :comicId, :comment, :date);", [
            "id" => $user_id,
            "comicId" => $comic_id,
            "comment" => $comment,
            "date" => date("Y-m-d H:i:s"),
        ]);
    }

    public function editComment($user_id, $comic_id, $comment)
    {
        return parent::executeSQL("UPDATE comments SET comment = :comment, date = :date 
                                            WHERE user_id = :id AND comic_id = :comicId;", [
            "id" => $user_id,
            "comicId" => $comic_id,
            "comment" => $comment,
            "date" => date("Y-m-d H:i:s"),
        ]);
    }

    public function deleteComment($user_id, $comic_id, $comment)
    {
        return parent::executeSQL("DELETE FROM comments WHERE comment = :comment
                                            AND user_id = :id AND comic_id = :comicId;", [
            "id" => $user_id,
            "comicId" => $comic_id,
            "comment" => $comment,
        ]);
    }
}
