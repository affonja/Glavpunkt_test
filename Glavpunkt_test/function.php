<?php

    function db_connect(array $db): mysqli
    {
        $connection = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['database']);
        if (!$connection) {
            exit(mysqli_connect_error());
        }
        mysqli_set_charset($connection, "utf8");
        return $connection;
    }
    function add_post(mysqli $connection, array $posts, int $counter, array &$post_added_error):int
    {
        $sql = <<<SQL
                INSERT INTO posts ( id, userId, title,body)
                VALUES ( ?,?,?,?)
                SQL;
        $stmt = mysqli_prepare($connection, $sql);

        foreach ($posts as $post) {
            mysqli_stmt_bind_param($stmt, "iiss", $post->id, $post->userId, $post->title, $post->body);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                $counter++;
            } else {
                $post_added_error[] = mysqli_stmt_error($stmt);
            }
        }
        mysqli_stmt_close($stmt);
        return $counter;
    }
    function add_comment(mysqli $connection, array $comments, int $counter, array &$comment_added_error):int
    {
        $sql = <<<SQL
                INSERT INTO comments ( id, postId, name, email, body)
                VALUES ( ?,?,?,?,?)
                SQL;
        $stmt = mysqli_prepare($connection, $sql);

        foreach ($comments as $comment) {
            mysqli_stmt_bind_param($stmt, "iisss", $comment->id, $comment->postId, $comment->name, $comment->email,
                $comment->body);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                $counter++;
            } else {
                $comment_added_error[] = mysqli_stmt_error($stmt);
            }
        }
        mysqli_stmt_close($stmt);
        return $counter;
    }
    function get_search_comment(mysqli $connection, string $search_query)
    {
        $query = <<<SQL
            SELECT
                posts.title AS post,
                comments.body AS comment
            FROM comments
            JOIN posts ON comments.postId=posts.id
            WHERE comments.body LIKE CONCAT('%', ?, '%')
          SQL;
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $search_query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
        if (!$result){
            return '0 совпадений';
        }
        return $result;
    }