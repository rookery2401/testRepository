<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>main_page</title>
    </head>
    <body>
        <div class="theme">
            <p>お題：ドラゴンボールが８つ揃うと何が起こる？</p>
        </div>
        <hr>
        <div class="post_form">
            <form method="POST" action="">
                <input type="text" name="name" placeholder="名前"><br>
                <textarea name="comment" cols=50 rows=3 placeholder="回答記入"></textarea><br>
                <input type="submit" name="submit" value="投稿"><br>
                <input type="text" name="type" value="post"><br>
            </form>
        </div>
        <hr>
        <div class="post_list">
            <p>投稿一覧</p>


            <?php
                require('./main_function.php');

                createTable($pdo, $tableName);
                // showTable($pdo); // テーブル一覧

                $postType = (isset($_POST["type"])) ? $_POST["type"] : "";
                $name = (isset($_POST["name"])) ? $_POST["name"] : "";
                $comment = (isset($_POST["comment"])) ? $_POST["comment"] : "";
                $date = date("Y/m/d H:i");

                if ($postType=="post") {
                    resisterData($pdo, $tableName, $name, $comment, $date);
                }
                showData($pdo, $tableName);
            ?>
        </div>
    </body>
</html>
