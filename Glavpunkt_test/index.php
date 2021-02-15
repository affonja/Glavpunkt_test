<?php
    require_once('init.php');

    $post_added_counter = add_post($connection, $posts_arr, $counter = 0, $post_added_error);
    $comment_added_counter = add_comment($connection, $comments_arr, $counter = 0, $comment_added_error);

    if (!empty($_GET)) {
        $search_query = trim(filter_input(INPUT_GET, 'search_field', FILTER_SANITIZE_STRING));
        if (strlen($search_query) < 3) {
            $search_result = 'Длина запроса должна быть больше 3 символов';
        } else {
            $search_result = get_search_comment($connection, $search_query) ?? $search_err = '0 совпадений';
        }
    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .post_title {
            font-weight: bold;
            color: #004261;
            padding: 5px;
            margin: 0px;
            background-color: #ddd;
        }

        .comments {
            font-family: Verdana;
            font-size: 12px;
            color: #000;
        }

        form {
            padding-bottom: 30px;
        }
    </style>
</head>
<body>
<form action="/" name="search" method="get">
    <label for="search_field">Найти комментарий
        <input type="text" name="search_field" id="search_field" size="50" value="<?= $search_query ?? '' ?>">
    </label>
    <input type="submit" value="Найти">
    <? if (isset($search_result) and gettype($search_result) === 'string'): ?>
        <p><?= $search_result; ?></p>
    <? endif; ?>
</form>
<?php
    if (isset($search_result) and gettype($search_result) === 'array') {
        foreach ($search_result as $item): ?>

            <div class="post_title">post: <?= strip_tags($item['post']); ?></div>
            <div class="comments"><?= strip_tags($item['comment']); ?></div><br>
        <?php endforeach;
    }; ?>

<script>console.log('Загружено <?=$post_added_counter;?> записей и <?=$comment_added_counter;?> комментариев')</script>
<script>console.log('<?=count($post_added_error);?> ошибок записей и <?=count($comment_added_error);?> ошибок комментариев')</script>
</body>
</html>



