<?php

/*
 * delete_task.php
 * POSTで送信されたIDのtasks レコードを削除する処理を行います
 */

session_start();

if (isset($_POST['delete_id'])) {
    require_once "./db_connection.php";

    $stmt = $dbh->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");

	/* POSTで受け取ったdelete_idと、ログイン中のユーザーのIDを使って、レコードを絞り込んで処理を実行 */
    $stmt->execute([$_POST['delete_id'], $_SESSION["login_id"]]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['flush_message'] = [
            'type' => 'success',
            'content' => "id: {$_POST['delete_id']} のTodoを削除しました",
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
