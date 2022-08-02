<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>
<?php include_once __DIR__ . '/_header.php' ?>

<body>
    <section class="login_content wrapper">
        <h1 class="login_title">ログイン</h1>
        <form class="login_form" action="" method="post">
            <label class="email_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email">
            <label class="password_label" for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <div class="button_area">
                <input type="submit" value="ログイン" class="login_button">
                <a href="signup.php" class="signup_page_button">新規ユーザー登録</a>
            </div>
        </form>
    </section>

    <!-- 葛川作 -->
    <div class="login_container">
        <h1 class="login_title">ログイン</h1>
        <div class="top_form">
            <p>ログインID(メールアドレス)</p>
            <input type="text" name="email" placeholder="メールアドレスをご入力ください">
        </div>
        <div class="top_form">
            <p>パスワード</p>
            <input type="text" name="password" placeholder="pスワードをご入力ください">
        </div>
    </div>
    <div class="detail">
        <input class="submit_button" type="submit" value="ログインする">
    </div>


    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
