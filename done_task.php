<?php

/*
 * done_task.php
 * POSTで送信されたIDのtasks レコードのdone を1(完了)にする処理を行います
 */

session_start();

if (isset($_POST['done_id'])) {
    require_once "./db_connection.php";

    $stmt = $dbh->prepare("UPDATE tasks SET done = 1 WHERE id = ? AND user_id = ?");
    /* POSTで受け取ったdone_idと、ログイン中のユーザーのIDを使って、レコードを絞り込んで処理を実行 */
    $stmt->execute([$_POST['done_id'], $_SESSION["login_id"]]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['flush_message'] = [
            'type' => 'success',
            'content' => "id: {$_POST['done_id']} のTodoを完了しました",
        ];
    } else {
        $_SESSION['flush_message'] = [
            'type' => 'danger',
            'content' => '存在しないタスクのIDが指定されました',
        ];
    }
} else {
    $_SESSION['flush_message'] = [
        'type' => 'danger',
        'content' => '存在しないタスクのIDが指定されました',
    ];
}

/* 一覧画面に遷移する */
header("Location: index.php");
