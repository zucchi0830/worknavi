<?php 
// セッション開始
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
<?php include_once __DIR__ . '/_header.php' ?>
    <section class="search_content wrapper">
    <h1 class="h1_confirm">求人投稿が完了しました！</h1>

    <a href="management.php" class="confirm_back_button">求人管理画面へ</a>
    </section>

<!-- フッター読み込み -->
<?php include_once __DIR__ . '/_footer.php' ?>
</body>
</html>
