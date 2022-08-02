<?php 
    // セッション開始
    session_start();
    ?>
<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
<?php include_once __DIR__ . '/_header.php' ?>

<h1>管理画面です</h1>

<a class="header_logout_button" href="logout.php" class="nav-link">ログアウトする</a>


<!-- フッター読み込み -->
<?php include_once __DIR__ . '/_footer.php' ?>
</body>
</html>
