<?php
namespace Ssg\Movie;

/**
 * Showing off a standard class with methods and properties.
 */
class MovieWrapper
{
    public function __construct()
    {
    }


    public function getAll($db)
    {
        $db->connect();
        $sql = "SELECT * FROM movie;";
        return $db->executeFetchAll($sql);
    }


    public function searchTitle($db, $search)
    {
        if ($search !== null) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            return $db->executeFetchAll($sql, [$search]);
        }
        return null;
    }


    public function searchYear($db, $fromYear, $toYear)
    {
        if ($fromYear && $toYear) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            return $db->executeFetchAll($sql, [$fromYear, $toYear]);
        } elseif ($fromYear) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            return $db->executeFetchAll($sql, [$fromYear]);
        } elseif ($toYear) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            return $db->executeFetchAll($sql, [$toYear]);
        }
        return null;
    }



    public function create($db, $title, $year, $imageUrl)
    {
        $image = $imageUrl;
        if ($imageUrl == null) {
            $image="img/noimage.png";
        }
        $db->connect();
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $db->execute($sql, [$title, $year, $image]);
    }


    public function read($db, $movieId)
    {
        if ($movieId !== null) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $movies = $db->executeFetchAll($sql, [$movieId]);
            if ($movies !== null && count($movies) > 0) {
                return $movies[0];
            }
        }
        return null;
    }


    public function update($db, $id, $title, $year, $imageUrl)
    {
        $image = $imageUrl;
        if ($imageUrl == null) {
            $image="img/noimage.png";
        }
        if ($id !== null) {
            $db->connect();
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$title, $year, $image, $id]);
        }
    }


    public function delete($db, $id)
    {
        if ($id !== null) {
            $db->connect();
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->executeFetchAll($sql, [$id]);
        }
    }
}
