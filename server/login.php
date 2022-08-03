<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

// ログイン判定
if (isset($_SESSION['current_user'])) {
    header('Location: management.php');
    exit;
}

$email = '';
$password = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    $errors = login_validate($email, $password);

    if (empty($errors)) {
        $user = find_user_by_email($email);
        if (!empty($user) && password_verify($password, $user['password'])) {
            $_SESSION['current_user']['id'] = $user['id'];
            $_SESSION['current_user']['name'] = $user['name'];
            $_SESSION['current_user']['full_name'] = $user['full_name'];            
            header('Location: management.php');
            exit;
        } else {
            $errors[] = MSG_EMAIL_PASSWORD_NOT_MATCH;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>

<body>
<?php include_once __DIR__ . '/_header.php' ?>
    <section class="login_content wrapper">
        <h1 class="login_title">ログイン</h1>
        <?php if (!empty($errors)) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li>
                        <?= h($error) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>        
        <form class="login_form" action="" method="post">

            <label class="email_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">

            <label class="password_label" for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password">

            <div class="button_area">
                <input type="submit" value="ログイン" class="login_button">
                <a href="signup.php" class="signup_page_button">新規登録はこちら</a>
            </div>
        </form>
    </section>

    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
