<?php

/*
 * login.php
 * フォームに入力された内容を用いて、ログイン判定を行います
 * ログインに成功したら、index.phpに遷移します
 */

session_start();
$err_msg = "";

/*
 * 1. SESSION["logged_in"]をチェック
 * trueならindex.phpに遷移します
 */
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    header("Location: index.php");
}

/*
 * 2. POSTデータがあるかをチェック
 * 両方入力されていれば判定を行い、なければエラーを表示します
 */
if (empty($_POST) === false) {
    if (empty($_POST["user_id"]) === false || empty($_POST["password"]) === false) {
        /* ログイン判定用の関数を実行 */
        $err_msg = auth_check();
    } else {
        $err_msg = "<p>ID・パスワードを入力してください</p>";
    }
}

/*
 * 3. 入力された値を、ID、パスワードと照合、ログインを判定します
 * ログインに成功していれば、SESSION["logged_in"]をtrueに設定し、
 * index.phpに遷移します
 */
function auth_check()
{

    require_once "db_connection.php";

    try {
        $stmt = $dbh->prepare("SELECT id, password FROM users WHERE name = ?");
        $stmt->execute([$_POST["user_name"]]);
        $correct_user = $stmt->fetch();

        if ($stmt->rowCount() > 0) { /* SQLの検索結果が1件以上のとき */
            if (md5($_POST["password"]) === $correct_user["password"]) {
                /* ハッシュ化した入力パスワードと、データベースの保存内容が同じ -> 認証成功) */
                $_SESSION["login_id"] = $correct_user["id"];
                $_SESSION["login_name"] = $_POST["user_name"];
                $_SESSION["logged_in"] = true;

                $dbh = null;
                header("Location: index.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    $dbh = null;
    $_SESSION["logged_in"] = false;
    return ("IDまたはパスワードが正しくありません");
}

/* 共通のhtml読み込みに使うphpファイルをインクルード */
include_once "./include.php";

?>

<!DOCTYPE html>
<html>

<head>
	<?php put_header();?>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

<div class="container my-auto">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <?php
                        /* エラーメッセージを表示する */
                        if ($err_msg !== "") {
                            print('<div class="alert alert-danger" role="alert">');
                            print($err_msg);
                            print('</div>');
                        }
                    ?>
                    <form id="login_form" name="login_form" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="input_user_name">ユーザーID</label>
                            <input id="input_user_name" name="user_name" type="text" class="form-control" placeholder="ユーザーID">
                        </div>
                        <div class="form-group">
                            <label for="input_password">パスワード</label>
                            <input id="input_password" name="password" type="password" class="form-control" placeholder="パスワード">
                        </div>
                        <button type="submit" class="btn btn-primary">認証</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php put_js_resources();?>
</body>

</html>