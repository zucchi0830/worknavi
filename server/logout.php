<?php

// セッション開始
session_start();

$_SESSION = [];

// クッキーのセッションIDを削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400);
}

// サーバー上のセッションファイルを削除
session_destroy();

// ログイン画面へリダイレクト
header('Location: index.php');
