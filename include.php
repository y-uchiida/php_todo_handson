<?php

/* 複数の画面で共通するヘッダー要素をまとめて出力する */
function put_header(){
	print <<< _EOL
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<title>PHP TODO App</title>
_EOL ;
}

/* 複数の画面で共通するscript要素をまとめて出力する */
function put_js_resources(){
	print <<< _EOL
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>	
_EOL ;

}

/* 直前の処理で発生したフラッシュメッセージを、画面上に表示する */
function put_flush_message(){
	/* セッションが開始していなければ、session_start()を実行する */
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if (isset($_SESSION['flush_message'])){
		print <<< _EOL
		<div class="row my-3 alert alert-{$_SESSION['flush_message']['type']} alert-dismissible fade show" role="alert">
			{$_SESSION['flush_message']['content']}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
_EOL ;

		/* 一度出力したら、次は表示しないようにセッションからフラッシュメッセージを除去する */
		unset($_SESSION['flush_message']);
	}
}