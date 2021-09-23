<?php

session_start();

/*
 * ログイン状態の確認
 */
if (isset($_SESSION["logged_in"]) == false || $_SESSION["logged_in"] !== true) {
    /* ログイン状態ではないとき */
    header("Location: login.php");
}

/* 共通のデータベース連携処理をまとめたphpファイルをインクルード */
include_once "./db_access.php";

/* 共通のhtml読み込みに使うphpファイルをインクルード */
include_once "./include.php";

/* todo リストの一覧を取得する
 * 処理に成功した場合は$res にtrueが、
 * 失敗した場合は$res にfalseが設定される
 */
$res = get_todo_list($_SESSION['login_id']);
if ($res["result"] === true){
    /* データの取得に成功していた場合、htmlに埋め込むtable要素の内容を作る */
    $todo_items = generate_todo_table($res["stmt"]);
} else {
    /* データベースからレコードが取得できなかったら、$elmにはエラーメッセージを入れておく */
    $todo_items = "<tr><td class='alert alert-danger' colspan='3'>データの取得に失敗しました</td></tr>";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<?php put_header();?>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <div class="row">
            <h1 class="col-md-4 col-sm-6 col-6 my-1">My Todo List</h1>
            <div class="col-md-4 col-sm-6 col-6 ml-auto text-right my-auto">
                <?php echo $_SESSION['login_name'] ?>
                <a href="./logout.php"><button class="btn btn-secondary">ログアウト</button></a>
            </div>
        </div>

        <?php 
            /* SESSION内に、flush_messageの値があれば表示する */
            put_flush_message();
        ?>
        
        <div class="row my-3">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#form_add_task" aria-expanded="false" aria-controls="collapse_form_control">
                <i class="fas fa-plus"></i> 新しいTodoを追加
            </button>
            <div class="col-12 px-0 collapse" id="form_add_task">
                <div class="card card-body my-2">
                    <!-- Todo 追加用のフォームを配置 -->
                    <form action="./add_task.php" method="POST">
                        <div class="form-group">
                            <label for="task_name">件名</label>
                            <input type="text" name="title" class="form-control col-md-6" id="task_name">
                        </div>
                        <div class="form-group">
                            <label for="task_detail">詳細</label>
                            <textarea name="detail" rows="4" class="form-control col-md-6" id="task_detail"></textarea>
                        </div>
                    <button type="submit" class="btn btn-primary">追加する</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">件名</th>
                        <th scope="col">詳細</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>     
                    <?php
                        /* データベースから取得したTodoの内容を一覧表示
                         * Todoのデータがなかった場合、またはエラーが発生している場合は、
                         * Todoの一覧の代わりにそのメッセージが表示される
                         */
                        print($todo_items);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<?php put_js_resources();?>
</body>

</html>
