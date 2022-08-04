<?php 
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

// idを基にデータを取得
$jobs = find_com_job_all();
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

</head>
<body>
<?php include_once __DIR__ . '/_header.php' ?>

    <section class="management_content wrapper">
        <h1 class="signup_title">管理画面</h1> 
            <div class="right_content">
                <div class="login_info">
                <ul>
                    <li class="num_li"><?= $current_user['id'] ?></li>
                    <li class="num_li"><?= $current_user['name'] ?></li>
                    <li class="num_li"><?= $current_user['full_name'] ?>さん</li>
                </ul>
                </div>
            </div>
        <table class="management_table">
            <tr>
                <th>会社名</th><th>募集職種</th><th>勤務地</th><th>仕事内容</th><th>掲載ステータス</th><th>編集</th>
            </tr>
        <?php foreach ($jobs as $job) : ?>
            <?php if($job['company_id'] == $current_user['id']) :?>
                <div class="jobtitle">
                    <tr>
                    <th><?=  $job['company_id'].$job['name'] ?></th><th><?=  $job['type'] ?></th><th><?=  $job['j_address_prefectures']. $job['j_address_detail']?></th>
                    <th><?=  $job['description']?></th><th><a class="signup_button" href="show.php?job_id=<?= h($job['id']) ?>">掲載中</a></th>
                    <th>編集する<br>一時停止<br>削除</th>
                </tr>
                </div>
            <?php endif; ?>    
        <?php endforeach; ?>
        </table>
            <div class="button_area">
                <a href="job_signup.php" class="signup_button" class="nav-link">求人を掲載する</a>
                <a href="logout.php" class="login_page_button" class="nav-link">ログアウトする</a>
            </div>
    </section>
    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>
</html>
