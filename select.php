<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>book list 表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">books register</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<?php
//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="registered_date | book_name | book_URL | book_comment";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $result_URL = $result["book_URL"];
    $pattern = '(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)';
    $replacement = '<a href="\1" target="_blank">\1</a>';
    $result_URL = mb_ereg_replace($pattern, $replacement, htmlspecialchars($result_URL));

    $view .="<p>";
    $view .= '<a href="detail.php?id=' . $result['id'] . '">';
    $view .=$result["registered_date"]." | ".$result["book_name"]." | ".$result_URL." | ".$result["book_comment"];
    $view .= '</a>';
    $view .= '<a href="delete.php?id=' . $result['id'] . '">';//追記
    $view .= '  [削除]';//追記
    $view .= '</a>';//追記
    $view .="</p>";
  }
}
// 出典：PHP、テキスト内のURLをリンクにする
// http://piyopiyocs.blog115.fc2.com/blog-entry-637.html

?>

<!-- Main[Start] -->
<div style="display:inline-flex">
<form method="post" action="">
<input type="submit" name="sort_name" value="書籍名順">
</form>

<form method="post" action="management.php">
<input type="submit" name="user_name" value="User管理画面">
</form>
</div>


<?php
$sort_name = filter_input(INPUT_POST, 'sort_name');
// if("書籍名順" === $_POST["sort_name"]){
if("書籍名順" === $sort_name){
//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY book_name ASC");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="registered_date | book_name | book_URL | book_comment";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $result_URL = $result["book_URL"];
    $pattern = '(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)';
    $replacement = '<a href="\1" target="_blank">\1</a>';
    $result_URL = mb_ereg_replace($pattern, $replacement, htmlspecialchars($result_URL));

    $view .="<p>";
    $view .=$result["registered_date"]." | ".$result["book_name"]." | ".$result_URL." | ".$result["book_comment"];
    $view .="</p>"; 
  }
}
}
// 出典：phpで文字列や数値を昇順と降順にするソートボタンを作ってみた
// https://qiita.com/bitcoinjpnnet/items/a27beb461f7960aed146

?>


<form method="post" action="export.php">
<input type="submit" name="submit" value="Export" />
</form>

<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>




