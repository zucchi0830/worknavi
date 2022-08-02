<header class="page_header wrapper">
    <h1>
                <a class="logo" href="index.php">
                    東北ワークナビ
                </a>
            </div>
        </div>
    </h1>
            <div class="right_content">
            <div class="login_info">
                <p>東北ワークナビについて</p>
                <p>無料で求人掲載する</p>
                <?php if (isset($current_user)) : ?>
                    <p>
                        <?= $current_user['name'] ?>さん
                    </p>
                    <a class="header_logout_button" href="logout.php" class="nav-link">管理画面へ</a>
                <?php else : ?>
                    <a class="header_login_button" href="login.php" class="nav-link">企業ログイン</a>
                <?php endif; ?>
        </div>
    </div>
</header>
