<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

$job_id = 0;

// セッションにidが保持されていなければ一覧画面にリダイレクト
// パラメータを受け取れなければ一覧画面にリダイレクト
if (empty($_SESSION['current_user']) || 
    empty($_GET['job_id'])) {
    header('Location: index.php');
    exit;
}

$job_id = filter_input(INPUT_GET, 'job_id');
$job = find_com_job($job_id);

status_off($job_id);
header('Location: management.php');
exit;

?>
