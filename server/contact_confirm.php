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
    <h1 class="h1_confirm">お問い合わせいただきありがとうございます。</h1><br>
    <a href="index.php" class="confirm_back_button">トップへ戻る</a>
    </section>

<!-- フッター読み込み -->
<?php include_once __DIR__ . '/_footer.php' ?>
</body>
</html>
