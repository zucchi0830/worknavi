<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>
<?php include_once __DIR__ . '/_header.php' ?>

<body>
    <div class="login_container">
        <h1 class="login_title">ログイン</h1>
        <div class="top_form">
            <p>ログインID</p>
            <input type="text" name="company" placeholder="職種名をご入力ください">
        </div>
        <div class="top_form">
            <p>パスワード</p>
            <input type="text" name="name" placeholder="職種名をご入力ください">
        </div>
    </div>
    <div class="detail">
        <input type="submit" value="ログインする">
    </div>


    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
