<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';
// セッション開始
session_start();

$current_user = '';

// パラメータが渡されていなければ一覧画面に戻す
$page = filter_input(INPUT_GET,'page');
$start = 10 * ($page - 1);
$address_keyword = filter_input(INPUT_GET,'address');
$search_address_job = search_address_com_job($start,$address_keyword);

if (empty($page)) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}

// 変数の初期化
$name = '';
$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['雇用形態を選択してください', '正社員', '契約社員', 'パートアルバイト', 'その他'];

// $companys_jobs = find_com_job_last10($start);
$job_count = find_job_all_status_on_count();
$job_count_address = search_address_com_job_count($address_keyword);

//検索用
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $search_address_job = search_address_com_job($address_keyword);
// }

var_dump(find_job_count_true($address_keyword,$job_count['COUNT(*)'],$job_count_address['COUNT(*)']));

function url_address(){
if (condition) {
    # code...
}
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

        <p><?= "該当求人は" . find_job_count_true($address_keyword,$job_count['COUNT(*)'],$job_count_address['COUNT(*)']) . "件です" ?></p>
        
        <div class="jobs job1">
        <?php foreach ($search_address_job as $job) : ?>
        <?= "求人id" . var_dump($job['id'] ); ?>
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
        <?php endforeach; ?>
    </div>
        <?php if ($page > 1 ) : ?>
            <a href="show_list.php?page=<?= h($page - 1) ?>"> <前の10件 </a>
        <?php elseif (find_job_count_true($address_keyword,$job_count['COUNT(*)'],$job_count_address['COUNT(*)']) - (intval($page)*10) > 0 ) : ?>
        <?php  var_dump($address_keyword); ?>
            <a href="show_list.php?page=<?= h($page + 1) . '&address=' . $address_keyword ?>">次の10件></a>
        <?php endif; ?>
            <center><?=  h($page) ?></center>

    <?php include_once __DIR__ . '/_footer.php' ?>


</body>

</html>
