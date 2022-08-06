<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';
// セッション開始
session_start();

$current_user = '';

// パラメータが渡されていなければ一覧画面に戻す
$type = filter_input(INPUT_GET,'type');
$employment = filter_input(INPUT_GET,'employment');
if (!empty($page) or !empty($address) or !empty($type) or !empty($type)) {
}else {
        header('Location: index.php');
    exit;

}

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

$start = 10 * ($page - 1);

// 変数の初期化
$name = '';
$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['雇用形態を選択してください', '正社員', '契約社員', 'パートアルバイト', 'その他'];

$companys_jobs = find_com_job_last10($start);
$job_count = find_job_all_status_true();

//検索用
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address_keyword = filter_input(INPUT_POST, 'j_address_prefectures');
    $search_address_job = search_address_com_job($address_keyword);
}
?>

<!DOCTYPE html>
<html lang="ja">
<!-- <head>の読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <div class="sub_title">
        <h1>求人情報一覧 </h1>
        <p><?= "該当求人は" . $job_count['COUNT(*)'] . "件です" ?></p>
        <div class="jobs job1">
        <?php foreach ($companys_jobs as $job) : ?>
        <?= "求人id" . var_dump($job['id'] ); ?>
        <!-- <//?php if ($job['id'] < $job_id ) : ?> -->
            <div class="jobtitle">
            <h1 class="index_job_title">会社名:<?=  $job['name'] ?></h1>
                <ul>
                    <li></li>
                    <li>職種:<?=  $job['type'] ?></li>
                    <li>勤務地:<?=  $job['j_address_prefectures']?></li>
                    <li>雇用形態:<?=  $job['employment'] ?></li>
                    <li>給与:<?=  $job['salary'] ?></li>
                    <li>勤務時間:<?=  $job['work_hours'] ?></li>
                    <li>休日:<?=  $job['holiday'] ?></li>
                </ul>
            <div class="detail">
                <a class="detail_button" href="show.php?job_id=<?= h($job['id']) ?>">詳細を見る</a>
            </div>
        </div>
        <hr>
        <!-- <//?php endif; ?> -->
        <?php endforeach; ?>
    </div>
    <?= "<pre>" ?>
    <?= "</pre>" ?>
        <?php if ($page > 1 ) : ?>
            <a class="detail_button" href="show_list.php?page=<?= h($page - 1) ?>"> <前の10件 </a>
        <?= h($page) ?>
        <?php elseif ($job_count['COUNT(*)'] - (intval($page)*10) < 10 ) : ?>
            <a class="detail_button" href="show_list.php?page=<?= h($page + 1) ?>">次の10件></a>
        <?php endif; ?>
    <?php include_once __DIR__ . '/_footer.php' ?>

</body>

</html>
