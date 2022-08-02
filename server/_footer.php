<footer>
    <div class="footer">
        <div class="footer_logo"><a href="index.php">東北ワークナビ</a></div>
        <div class="footer_list">
            <ul>
                <li><a href="about.php">東北ワークナビとは</a></li>
                <li><a href="signup.php">無料で求人掲載</a></li>
                    <?php if (!empty($current_user)) : ?>
                        <li><a class="header_logout_button" href="management.php" class="nav-link">管理画面へ</a></li>
                    <?php else : ?>
                        <li><a class="header_login_button" href="login.php" class="nav-link">ログイン</a></li>
                    <?php endif; ?>
                <li><a href="contact.php">お問い合わせ</a></li>
            </ul>
        </div>
</footer>
