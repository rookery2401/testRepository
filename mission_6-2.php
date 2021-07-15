<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>mission_6-2.php</title>
    </head>
    <body>
        <div class="login_form">
            <form method="POST" action="">
                <input type="text" name="account" placeholder="アカウント名"><br>
                <input type="text" name="password" placeholder="パスワード"><br>
                <input type="submit" name="login" value="ログイン"><br>
            </form>
        </div>
        <div class="create_account_form">
            <from method="POST" action="">
                <input type="text" name="new_account" placeholder="アカウント名"><br>
                <input type="text" name="password" placeholder="パスワード"><br>
                <input type="text" name="comfirm_password" placeholder="パスワード（確認）"><br>
                <input type="submit" name="create_account" value="新規登録">
            </from>
            <?php require('./test.php') ?>
            <?php echo add(1,2); ?>
        </div>
    </body>
</html>