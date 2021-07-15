<?php
    $dsn = 'mysql:dbname=tb221169db;host=localhost';
    $user = 'tb-221169';
    $dbPassword = 'ZpzdPAZV3d';
    $pdo = new PDO($dsn, $user, $dbPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $tableName = "commentTable";

    // テーブルの作成
    function createTable($pdo, $tableName) {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName "
            ."("
            ." id INT AUTO_INCREMENT PRIMARY KEY,"
            ." name nchar(32),"
            ." comment TEXT,"
            ." date TEXT,"
            ." password char(10)"
            .");";
        $stmt = $pdo->query($sql);
    }

    // テーブルの表示
    function showTable($pdo) {
        $sql = "SHOW TABLES";
        $result = $pdo->query($sql);
        foreach ($result as $row) {
            echo $row[0];
            echo "<br>";
        }
        echo "<hr>";
    }

    // データの登録
    function resisterData($pdo, $tableName, $name, $comment, $date) {
        $sql = "INSERT INTO $tableName (name, comment, date) VALUES (:name, :comment, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
    }

    // データの表示
    function showData($pdo, $tableName) {
        $sql = "SELECT*FROM $tableName";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row) {
            echo $row['id']." ";
            echo $row['name']." ";
            echo "<span class='comment'>";
            echo $row['comment']." ";
            echo "</span>";
            echo $row['date']." ";
            echo "<br>";
        }
    }

    // データの削除
    function deleteData($pdo, $tableName, $id) {
        $sql = "DELETE FROM $tableName WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // データの編集
    function updateData($pdo, $tableName, $id, $comment, $date) {
        $sql = "UPDATE $tableName SET comment=:comment, date=:date WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
?>