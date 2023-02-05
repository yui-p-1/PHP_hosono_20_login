<?php
//1.外部ファイル読み込みしてDB接続
require_once('funcs.php');
$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET['id'];

//3．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id;");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
$view = '';
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();//ここを追記！！
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>PHP_bookmark</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">book list</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>フリーアンケート</legend>
     <label>書籍名：<input type="text" name="book_name" value="<?= $result["book_name"] ?>"></label><br>
     <label>書籍URL：<input type="text" name="book_URL" value="<?= $result["book_URL"] ?>"></label><br>
     <label>書籍コメント：<textArea name="book_comment" rows="4" cols="40"><?= $result["book_comment"] ?></textArea></label><br>
     <input type="hidden" name="id" value="<?= $result['id'] ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>

<form name="myform">
  <input type="file" name="file">
</form>
<button type="button" id="btn1" onclick="sendExcel()">送信</button>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

// エクセルファイル送信処理
var sendExcel = function () {
  // フォームを取得しフォームデータを作成する
  var formData = new FormData(document.forms.myform);
  $.ajax({
    method: 'POST',
    url: './insert_file.php',
    processData: false,
    contentType: false,
    cache: false,
    timeout: 50000,
    data: formData
  }).done(function (response) {
    // 正常時の処理 ...
  }).fail(function (jqXHR) {
    // 異常時の処理 ...
  });
};

</script>

<!-- Main[End] -->


</body>
</html>