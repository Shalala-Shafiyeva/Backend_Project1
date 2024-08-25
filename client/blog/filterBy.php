<?php

include_once "../../index.php";
$url = "/backend_project1/client/blog/select.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = htmlspecialchars(post('title'));
    $description = htmlspecialchars(post('description'));
    $author = htmlspecialchars(post('author'));
    $category = htmlspecialchars(post('category'));


    $sql = "SELECT blogs.*, 
                   users.name AS author_name, 
                   users.surname AS author_surname, 
                   catigories.name AS category_name 
            FROM blogs 
            LEFT JOIN users ON users.id = blogs.user_id
            LEFT JOIN catigories ON catigories.id = blogs.category_id
            WHERE blogs.user_id=?
            ";
    if (!empty($title)) {
        $sql .= " AND blogs.title LIKE '%$title%' ";
        $url .= "?title=$title";
    }
    if (!empty($description)) {
        $sql .= "AND blogs.description LIKE '%$description%' ";
        if (strpos($url, "?")) {
            $url .= "&description=$description";
        } else {
            $url .= "?description=$description";
        }
    }
    if (!empty($author)) {
        $sql .= "AND users.name LIKE '%$author%'";
        if (strpos($url, "?")) {
            $url .= "&author=$author";
        } else {
            $url .= "?author=$author";
        }
    }
    if (!empty($category)) {
        $sql .= "AND blogs.category_id LIKE '%$category%' ";
        if (strpos($url, "?")) {
            $url .= "&category=$category";
        } else {
            $url .= "?category=$category";
        }
    }

    $filterQuery = $connection->prepare($sql);
    $filterQuery->execute([$_SESSION['user_id']]);
    $blogs = $filterQuery->fetchAll(PDO::FETCH_ASSOC);
    if (count($blogs) > 0) {
        $_SESSION['filtered_blogs'] = $blogs;
    } else {
        $_SESSION['filtered_blogs'] = [];
    }
    header("location: $url");
}
