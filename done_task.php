<?php

/*
 * done_task.php
 * POSTで送信されたIDのtasks レコードのdone を1(完了)にする処理を行います
 */

session_start();

if (isset($_POST['done_id'])) { /* isset($_POST['done_id']) で、完了するTodoのidが指定されているか確認し、指定されている場合は処理を行う */
    require_once "./db_connection.php";

//    $stmt = $dbh->prepare(" XXXレコードを完了にするためのプレースホルダ付きSQLを入力するXXX ");

    /* POSTで受け取ったdone_idと、ログイン中のユーザーのIDを使って、レコードを絞り込んで処理を実行 */
//    $stmt->execute( XXXレコードを完了にするSQLを実行するため、SQLのプレースホルダに渡すデータを入力するXXX );

    /* $stmt->rowCount() はexecuteで実行したSQLが影響したデータベースレコードの件数を取得する
     * これを使って、データの更新ができたかを確認し、フラッシュメッセージをセットする
     */
    if ($stmt->rowCount() > 0) { /* 完了に設定できた場合は、> 0 になる */
        $_SESSION['flush_message'] = [
            'type' => 'success',
            'content' => "id: {$_POST['done_id']} のTodoを完了しました",
        ];
    } else { /* > 0 ではない場合(データを追加できなかった場合)、エラー扱いとする */
        $_SESSION['flush_message'] = [
            'type' => 'danger',
            'content' => '存在しないタスクのIDが指定されました',
        ];
    }
    /* $_POST['done_id'] が送信されていた場合の処理、ここまで */

} else { /* $_POST['done_id']が送信されていなかった場合、エラー扱いとする */
    $_SESSION['flush_message'] = [
        'type' => 'danger',
        'content' => '存在しないタスクのIDが指定されました',
    ];
}

/* 一覧画面に遷移する */
header("Location: index.php");
