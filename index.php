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
    <div class="navbar-header"><a class="navbar-brand" href="login.php">login</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">logout</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert_direct.php">
  <div class="jumbotron">
   <fieldset>
    <legend>フリーアンケート</legend>
     <label>書籍名：<input type="text" name="book_name"></label><br>
     <label>書籍URL：<input type="text" name="book_URL"></label><br>
     <label>書籍コメント：<textArea name="book_comment" rows="4" cols="40"></textArea></label><br>
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
