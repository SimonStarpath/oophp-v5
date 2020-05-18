<?php
/**
 * Routes for the movie database
 */


/**
 * Show all movies.
 */
$app->router->get("movie", function () use ($app) {
    $title = "Movie database | oophp";

    $app->db->connect();
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("movie/header", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/index", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/footer", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * POST-route: Create a movie.
 */
$app->router->post("movie", function () use ($app) {
    return $app->response->redirect("movie/index");
});


/**
 * Search movies by title.
 */
$app->router->get("movie/search-title", function () use ($app) {
    $title = "Search Movie database | oophp";
    $res = "";

    $searchTitle = getGet("searchTitle");
    if ($searchTitle) {
        $app->db->connect();
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $res = $app->db->executeFetchAll($sql, [$searchTitle]);
    }

    $app->page->add("movie/header", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/search-title", [
        "resultset" => $res,
        "searchTitle" => $searchTitle,
    ]);

    $app->page->add("movie/index", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/footer", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Search movies by year.
 */
$app->router->get("movie/search-year", function () use ($app) {
    $title = "Search Movie database | oophp";
    $res = "";

    $year1 = getGet("year1");
    $year2 = getGet("year2");

    if ($year1 && $year2) {
        $app->db->connect();
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1, $year2]);
    } elseif ($year1) {
        $app->db->connect();
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1]);
    } elseif ($year2) {
        $app->db->connect();
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year2]);
    }

    $app->page->add("movie/header", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/search-year", [
        "resultset" => $res,
        "year1" => $year1,
        "year2" => $year2,
    ]);

    $app->page->add("movie/index", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/footer", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * GET-route: Edit a movie.
 */
$app->router->get("movie/edit", function () use ($app) {
    $title = "Edit Movie | oophp";
    $res = "";
    $movie = null;

    $movieId = getGet("movieId");
    if ($movieId) {
        $app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];
    }

    $app->page->add("movie/header", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/edit", [
        "movie" => $movie,
    ]);

    $app->page->add("movie/footer", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * POST-route: Edit a movie.
 */
$app->router->post("movie/edit", function () use ($app) {
    $title = "Update Movie | oophp";
    $res = "";
    $movie = null;

    $movieId = getPost("movieId");
    $movieTitle = getPost("movieTitle");
    $movieYear = getPost("movieYear");
    $movieImage = getPost("movieImage");

    if ($movieId) {
        $app->db->connect();
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    }

    //return $app->response->redirect("movie/edit?movieId=$movieId");
    return $app->response->redirect("movie/view");
});



/**
 * Delete a movie.
 */
$app->router->get("movie/delete", function () use ($app) {
    $title = "Delete Movie | oophp";
    $res = "";
    $movie = null;

    $movieId = getGet("movieId");
    if ($movieId) {
        $app->db->connect();
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->executeFetchAll($sql, [$movieId]);
    }

    return $app->response->redirect("movie/index");
});



/**
 * GET-route: Create a movie.
 */
$app->router->get("movie/create", function () use ($app) {
    $title = "Create Movie | oophp";
    $res = "";

    $app->page->add("movie/header", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/create", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/footer", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * POST-route: Create a movie.
 */
$app->router->post("movie/create", function () use ($app) {
    $title = "Create Movie | oophp";
    $res = "";

    $movieTitle = getPost("movieTitle");
    $movieYear = getPost("movieYear");
    $movieImage = getPost("movieImage");

    $app->db->connect();
    $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
    $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage]);

    return $app->response->redirect("movie/index");
});


/**
 * GET-route: View a movie.
 */
$app->router->get("movie/view", function () use ($app) {
    $title = "View Movie | oophp";
    $res = "";
    $movie = null;

    $movieId = getGet("movieId");
    if ($movieId) {
        $app->db->connect();
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];
    }

    $app->page->add("movie/header", [
        "resultset" => $res,
    ]);

    $app->page->add("movie/show", [
        "movie" => $movie,
    ]);

    $app->page->add("movie/footer", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});
