<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>a_test5-1</title>
        <style type="text/css">
            span {display: inline-block; width: 100px;}
            body {margin-left: 50px; margin-top: 50px;}
            hr {width: 400px; margin-left: 0px;}
            
        </style>
    </head>
    <body>
        <?php
            // DBの接続設定
            $dsn = 'データベース名';
            $user = 'ユーザー名';
            $password = 'パスワード';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            $tableName = "tbTest1";
            
            // テーブル作成
            $sql = "CREATE TABLE IF NOT EXISTS $tableName "
                ."("
                ." id INT AUTO_INCREMENT PRIMARY KEY,"
                ." name nchar(32),"
                ." comment TEXT,"
                ." date TEXT,"
                ." password char(10)"
                .");";
            $stmt = $pdo->query($sql);
            
            // データの取得
            function getData($pdo, $tableName, $id) {
                $sql = "SELECT*FROM $tableName WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                
                $results = $stmt->fetchAll();
                $name = $results[0]['name'];
                $comment = $results[0]['comment'];
                return [$name, $comment];
            }
            
            // パスワードの取得
            function getPassword($pdo, $tableName, $id) {
                $sql = "SELECT*FROM $tableName WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $results = $stmt->fetchAll();
                $password = $results[0]['password'];
                return $password;
            }
            
            $formType = $_POST["type"];
            $postID = 0;
            if ($formType=="edit") {
                $id = $_POST["editID"];
                $password = getPassword($pdo, $tableName, $id);
                $inputPassword = $_POST["inputPassword"];
                if ($inputPassword==$password) {
                    $id = $_POST["editID"];
                    list($referName, $referComment) = getData($pdo, $tableName, $id);
                    $postID = $id;
                } else {
                    echo "パスワードが間違っています！";
                }
            }
        ?>
        
        <form method="POST" action="">
            <p>【  投稿フォーム  】</p>
            <input type="hidden" name="postID" value="<?php echo $postID; ?>"><br>
            <span>名前：</span><input type="text" name="name" value="<?php echo $referName; ?>"><br>
            <span>コメント：</span><input type="text" name="comment" value="<?php echo $referComment; ?>"><br>
            <span>パスワード：</span><input type="password" name="inputPassword"><br>
            <input type="submit" name="submit" value="送信">
            <input type="hidden" name="type" value="post">
        </form>
        <form method="POST" action="">
            <p>【  削除フォーム  】</p>
            <span>削除番号：</span><input type="text" name="deleteID"><br>
            <span>パスワード：</span><input type="text" name="inputPassword"><br>
            <input type="submit" name="submit" value="削除">
            <input type="hidden" name="type" value="delete">
        </form>
        <form method="POST" action="">
            <p>【  編集フォーム  】</p>
            <span>編集番号：</span><input type="text" name="editID"><br>
            <span>パスワード：</span><input type="text" name="inputPassword"><br>
            <input type="submit" name="submit" value="編集">
            <input type="hidden" name="type" value="edit">
        </form>
        <hr>
        <?php
            
            // テーブルの表示
            $sql = "SHOW TABLES";
            $results = $pdo->query($sql);
            echo "テーブル一覧<br>";
            foreach ($results as $item) {
                echo $item[0]."<br>";
            }
            echo "<hr>";
            
            // データの登録
            function resisterData($pdo, $tableName, $name, $comment, $date, $password) {
                $sql = "INSERT INTO $tableName (name, comment, date, password) VALUES (:name, :comment, :date, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
            }
            
            // データの更新
            function updateData($pdo, $tableName, $id, $name, $comment, $date) {
                $sql = "UPDATE $tableName SET name=:name, comment=:comment, date=:date WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            // データの削除
            function deleteData($pdo, $tableName, $id) {
                // データの削除
                $sql = "DELETE FROM $tableName WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            
            // データの表示
            function showData($pdo, $tableName) {
                $sql = "SELECT*FROM $tableName";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                echo "<div>";
                echo "テーブル名：$tableName<br>";
                foreach ($results as $row) {
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo "「";
                    echo $row['comment'];
                    echo "」 ";
                    echo $row['date']." ";
                    echo $row['password']." ";
                    echo "<br>";
                }
                echo "</div>";
            }
            
            
            
            // フォーム処理
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $date = date("Y/m/d H:i");
            $inputPassword = $_POST["inputPassword"];
            
            if ($formType=="post" && $name!="" && $comment!="") {
                $postID = $_POST["postID"];
                 // 新規投稿処理
                if ($postID==0 && $inputPassword!="") {
                    resisterData($pdo, $tableName, $name, $comment, $date, $inputPassword);
                
                // 編集処理
                } elseif ($postID!="") {
                    $id = $postID;
                    $password = getPassword($pdo, $tableName, $id);
                    if ($inputPassword==$password) {
                        updateData($pdo, $tableName, $id, $name, $comment, $date);
                    } else {
                        echo "パスワードが間違っています！";
                    }
                }
            // 削除処理
            } elseif ($formType=="delete") {
                $id = $_POST["deleteID"];
                $password = getPassword($pdo, $tableName, $id);
                if ($inputPassword==$password) {
                    deleteData($pdo, $tableName, $id);
                } else {
                    echo "パスワードが間違っています！";
                }
            }
            
            showData($pdo, $tableName); //データの表示
        ?>
    </body>
</html>
