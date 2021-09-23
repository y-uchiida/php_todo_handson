<?php

/*
 * db_access.php
 * データベースへアクセスをしてデータを取得する関数をまとめたファイルです
 * このファイルをインクルードして、関数を呼び出すことで、index.phpなどのプログラム記述の見通しが良くなります
 */

/* get_todo_list()
 * データベースから、ログイン中のユーザーのTodoのコードを取り出します
 */
function get_todo_list($user_id){
	/* データベースとのコネクションを開く
	 * $dbb でPDOオブジェクトが使えるようになる
	 */
    require_once "db_connection.php";

	/* プレースホルダつきSQLを作成する */
	$stmt = $dbh->prepare("SELECT * FROM tasks WHERE user_id = ? AND done = 0 ORDER BY id DESC");

	/* execute() に、配列形式でプレースホルダの値(ログイン中ユーザーのID)を渡す */
	try {
		$ret = $stmt->execute([$user_id]);
		if ($ret === true) {
			/* データ取得が成功していたら、trueを返す */
			return (["result" => true, "stmt" => $stmt]);
		} else {
			/* データ取得が失敗していたら、falseを返す */
			return (["result" => false, "stmt" => $stmt]);
		}
	} catch(PDOException $e){
		return (["result" => false, "exeption" => $e]);
	}
}

/* generate_todo_table()
 * データベースから取り出したTodoレコードのステートメントオブジェクトを使って、
 * 画面に表示するtable要素を生成します
 */
function generate_todo_table($stmt){
	if ($stmt->rowCount() === 0){
		return ("<tr><td colspan='3'>データがありません</td></tr>");
	}
	$elms = ""; /* tableの要素をまとめて入れておく変数 */
	while($item = $stmt->fetch()){
		$tr = "<tr>
		    <td class='align-top'>{$item['title']}</td>
		    <td class='align-top'>{$item['detail']}</td>
			<td class='align-middle'>
				<div class='d-flex text-right'>
					<form action='./done_task.php' method='POST' class='d-inline-block'>
						<button type='submit' name='done_id' value='{$item['id']}' class='btn btn-success mr-2 py-1 text-nowrap '><i class='far fa-check-square'></i> 完了</button>
					</form>
					<form action='./delete_task.php' method='POST' class='d-inline-block'>
						<button type='submit' name='delete_id' value='{$item['id']}' class='btn btn-danger  ml-2 py-1 text-nowrap '><i class='fas fa-trash-alt'></i> 削除</button>
					</form>
				</div>
			</td>
		</tr>";

		/* $elmsに、今回の処理で作成した$trの内容を追記する */
		$elms .= $tr;
	}
	return ($elms); /* $elmsは、最初から最後まですべての$tr の内容を結合した内容になっている */
}