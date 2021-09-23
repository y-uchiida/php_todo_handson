<?php

/*
 * add_task.php
 * POSTで送信されたtasks のデータを追加する処理を行います
 */

session_start();

if (isset($_POST)) {
    require_once "./db_connection.php";

    $stmt = $dbh->prepare("INSERT INTO tasks (title, detail, user_id) VALUES(?, ?, ?)");

	/* POSTで受け取った値と、ログイン中のユーザーのIDを使って、データをテーブルに追加
	 */
    $stmt->execute([$_POST['title'], $_POST['detail'], $_SESSION["login_id"]]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['flush_message'] = [
            'type' => 'success',
            'content' => "Todoを追加しました",
        ];
    } else {
        $_SESSION['flush_message'] = [
            'type' => 'danger',
            'content' => 'Todoの追加に失敗しました',
        ];
    }
} else {
    $_SESSION['flush_message'] = [
        'type' => 'danger',
        'content' => 'データが送信されていません',
    ];
}

/* 一覧画面に遷移する */
header("Location: index.php");
