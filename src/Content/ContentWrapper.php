<?php
namespace Ssg\Content;

/**
 * Showing off a standard class with methods and properties.
 */
class ContentWrapper
{
    public function __construct()
    {
    }


    public function getAll($db)
    {
        $db->connect();
        $sql = "SELECT * FROM content;";
        return $db->executeFetchAll($sql);
    }



    public function create($db, $title)
    {
        $db->connect();
        $sql = "INSERT INTO content (title) VALUES (?);";
        $db->execute($sql, [$title]);
        return $db->lastInsertId();
    }


    public function read($db, $contentId)
    {
        $db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";
        return $db->executeFetch($sql, [$contentId]);
    }


    public function update($db, $params)
    {
        $db->connect();
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $db->execute($sql, $params);
    }


    public function delete($db, $contentId)
    {
        if ($contentId !== null) {
            $db->connect();
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $db->execute($sql, [$contentId]);
        }
    }



    public function undelete($db, $contentId)
    {
        if ($contentId !== null) {
            $db->connect();
            $sql = "UPDATE content SET deleted=NULL WHERE id=?;";
            $db->execute($sql, [$contentId]);
        }
    }



    public function findSlug($db, $search)
    {
        if ($search !== null) {
            $db->connect();
            $sql = "SELECT * FROM content WHERE slug LIKE ?;";
            return $db->executeFetch($sql, [$search]);
        }
        return null;
    }



    public function getAllBlog($db)
    {
        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        return $db->executeFetchAll($sql, ["post"]);
    }


    public function getBlogBySlug($db, $slug)
    {
        $db->connect();
        $sql = <<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
slug = ?
AND type = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
ORDER BY published DESC
;
EOD;
        return $db->executeFetch($sql, [$slug, "post"]);
    }



    public function getAllPages($db)
    {
        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        return $db->executeFetchAll($sql, ["page"]);
    }


    public function getPageBySlug($db, $slug)
    {
        $db->connect();
        $sql = <<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
(path = ? OR slug = ?)
AND type = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
;
EOD;
        return $db->executeFetch($sql, [$slug, $slug, "page"]);
    }
}
