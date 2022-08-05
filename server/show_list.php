<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';
// セッション開始
session_start();

$current_user = '';

// パラメータが渡されていなければ一覧画面に戻す
$page_id = filter_input(INPUT_GET,'page_id');
if (empty($page_id)) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

$page = $_REQUEST['page_id'];
$start = 10 * ($page-1);

// 変数の初期化
$name = '';
$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['雇用形態を選択してください', '正社員', '契約社員', 'パートアルバイト', 'その他'];

$companys_jobs = find_com_job_last10($start);
?>

<!DOCTYPE html>
<html lang="ja">
<!-- <head>の読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <div class="sub_title">
        <h1>最新の求人(10件)</h1>
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
        <?php if ($page > 1 ) : ?>
            <a class="detail_button" href="show_list.php?page_id=<?= h($page - 1) ?>"> <前の10件 </a>
        <?php endif; ?>    
            <a class="detail_button" href="show_list.php?page_id=<?= h($page + 1) ?>">次の10件></a>
        
    <?php include_once __DIR__ . '/_footer.php' ?>

</body>

</html>
