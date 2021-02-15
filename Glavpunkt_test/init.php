<?php
    require_once ('function.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $db = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'database' => 'baserecord'
    ];
    $connection = db_connect($db);

    $file_posts = 'https://jsonplaceholder.typicode.com/posts';
    $file_comments = 'https://jsonplaceholder.typicode.com/comments';
    $posts_arr = json_decode(file_get_contents($file_posts));
    $comments_arr = json_decode(file_get_contents($file_comments));
    $post_added_error = [];
    $comment_added_error = [];