<?php
namespace Ssg\Content;

/**
 * Showing off a standard class with methods and properties.
 */
class LoginWrapper
{
    public function __construct()
    {
    }

    public function findUser($db, $userId)
    {
        if ($userId !== null) {
            $db->connect();
            $sql = "SELECT * FROM login WHERE userid LIKE ?;";
            return $db->executeFetch($sql, [$userId]);
        }
        return null;
    }
}
