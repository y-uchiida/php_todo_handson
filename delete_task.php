<?php

/*
 * delete_task.php
 * POSTで送信されたIDのtasks レコードを削除する処理を行います
 */

session_start();

if (isset($_POST['delete_id'])) { /* isset($_POST['delete_id']) で、削除するTodoのidが指定されているか確認し、指定されている場合は処理を行う */
    require_once "./db_connection.php";

//    $stmt = $dbh->prepare(" XXXレコードを削除するためのプレースホルダ付きSQLを入力するXXX ");

	/* POSTで受け取ったdelete_idと、ログイン中のユーザーのIDを使って、レコードを絞り込んで処理を実行 */
//    $stmt->execute( XXXレコードを削除するSQLを実行するため、SQLのプレースホルダに渡すデータを入力するXXX );

    /* $stmt->rowCount() はexecuteで実行したSQLが影響したデータベースレコードの件数を取得する
     * これを使って、データの削除ができたかを確認し、フラッシュメッセージをセットする
     */
    if ($stmt->rowCount() > 0) { /* 削除できた場合は、> 0 になる */
        $_SESSION['flush_message'] = [
//        XXX done_task.php を参考に、$_SESSIONにフラッシュメッセージのタイプ(type)を設定する XXX
//        XXX done_task.php を参考に、$_SESSIONにフラッシュメッセージの内容(content)を設定する XXX
        ];
    } else { /* > 0 ではない場合(データを削除できなかった場合)、エラー扱いとする */
        $_SESSION['flush_message'] = [
//        XXX done_task.php を参考に、$_SESSIONにフラッシュメッセージのタイプ(type)を設定する XXX
//        XXX done_task.php を参考に、$_SESSIONにフラッシュメッセージの内容(content)を設定する XXX
        ];
    }
    /* $_POST['delete_id'] が送信されていた場合の処理、ここまで */

} else { /* $_POST['delete_id']が送信されていなかった場合、エラー扱いとする */
    $_SESSION['flush_message'] = [
//        XXX done_task.php を参考に、$_SESSIONにフラッシュメッセージのタイプ(type)を設定する XXX
//        XXX done_task.php を参考に、$_SESSIONにフラッシュメッセージの内容(content)を設定する XXX
    ];
}

/* 一覧画面に遷移する */
header("Location: index.php");
