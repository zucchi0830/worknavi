<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

// idを基にデータを取得
$jobs = find_com_job_all();

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

$myjob = find_job_com($current_user['id']);
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
                    <!-- <li class="num_li"><?= $current_user['id'] ?></li> -->
                    <li class="num_li"><?= $current_user['name'] ?></li>
                    <li class="num_li"><?= $current_user['full_name'] ?>さん</li>
                </ul>
            </div>
        </div>
            <?php if (empty($myjob['company_id'])) : ?>    
                <p class="p_management">作成した求人がありません。</p>
            <?php elseif(!empty($myjob['company_id'])): ?>
            <table class="management_table">
                <tr>
                    <th class="th_type th1">職種名</th>
                    <th class="th_address th2">勤務地</th>
                    <th class="th_created th3">作成日</th>
                    <th class="th_view th4">閲覧数</th>
                    <th class="th_status th5">掲載ステータス</th>
                    <th class="th_edit th6">編集</th>
                </tr>
            <?php endif; ?>
        <?php foreach ($jobs as $job) : ?>
                <?php if ($job['company_id'] == $current_user['id']) : ?>
                    <div class="jobtitle">
                        <tr>
                            <th><?= $job['id'].$job['type']?></th>
                            <th><?= $job['j_address_prefectures'] . $job['j_address_detail'] ?></th>
                            <th><?= $job['created_at'] ?></th>
                            <th><?= "300" ?></th>
                            <th>
                            <?php if ($job['status'] == true) : ?>
                                <a class="status_on_now_button" href="show.php?job_id=<?= h($job['id']) ?>">掲載中</a>
                            <?php elseif($job['status'] == false) : ?>
                                <a class="status_off_now_button" href="show.php?job_id=<?= h($job['id']) ?>">掲載停止中</a> 
                            <?php endif; ?>
                                </th>
                                <th><a href="edit.php?job_id=<?= h($job['id']) ?>">編集する</a>
                            <?php if ($job['status'] == true) : ?>
                                <br><button class="status_off_button" onclick="if (!confirm('掲載を停止してよろしいですか？')) {return false}; 
                                location.href='status_off.php?job_id=<?= h($job['id']) ?>'">掲載停止</button>
                            <?php elseif($job['status'] == false) : ?>
                                <br><button class="status_on_button" onclick="if (!confirm('求人を掲載してよろしいですか？')) {return false}; 
                                location.href='status_on.php?job_id=<?= h($job['id']) ?>'">掲載開始</button>
                            <?php endif; ?>
                                <br><button class="delete_button" onclick="if (!confirm('本当に削除してよろしいですか？')) {return false}; 
                                location.href='delete.php?job_id=<?= h($job['id']) ?>'">削除</button>
                                <br><button class="copy_button" onclick="if (!confirm('この求人をコピーしますか？')) {return false}; 
                                location.href='job_signup_copy.php?job_copy_id=<?= h($job['id']) ?>'">コピーして求人作成</button>                                
                            </th>
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
