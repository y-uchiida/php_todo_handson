<?php

/*
 * delete_task.php
 * POSTで送信されたIDのtasks レコードを削除する処理を行います
 */

session_start();

if (isset($_POST['delete_id'])) { /* isset($_POST['delete_id']) で、削除するTodoのidが指定されているか確認し、指定されている場合は処理を行う */
    require_once "./db_connection.php";

    $stmt = $dbh->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");

	/* POSTで受け取ったdelete_idと、ログイン中のユーザーのIDを使って、レコードを絞り込んで処理を実行 */
    $stmt->execute([$_POST['delete_id'], $_SESSION["login_id"]]);

    /* $stmt->rowCount() はexecuteで実行したSQLが影響したデータベースレコードの件数を取得する
     * これを使って、データの削除ができたかを確認し、フラッシュメッセージをセットする
     */
    if ($stmt->rowCount() > 0) { /* 削除できた場合は、> 0 になる */
        $_SESSION['flush_message'] = [
            'type' => 'success',
            'content' => "id: {$_POST['delete_id']} のTodoを削除しました",
        ];
    } else { /* > 0 ではない場合(データを削除できなかった場合)、エラー扱いとする */
        $_SESSION['flush_message'] = [
            'type' => 'danger',
            'content' => '存在しないタスクのIDが指定されました',
        ];
    }
    /* $_POST['delete_id'] が送信されていた場合の処理、ここまで */

} else { /* $_POST['delete_id']が送信されていなかった場合、エラー扱いとする */
    $_SESSION['flush_message'] = [
        'type' => 'danger',
        'content' => '存在しないタスクのIDが指定されました',
    ];
}

/* 一覧画面に遷移する */
header("Location: index.php");
