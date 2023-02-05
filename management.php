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
  <nav class="navbar navbar-default" style="background-color:gray">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">management</a>
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
$view="registered_date | id | user_name";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .="<p>";

    //チャレンジ
    $view .= '<a href="user_register.php?id=' . $result['id'] . '">';
    $view .=$result["registered_date"]." | ".$result['id']." | ".$result["user_name"];
    $view .= '</a>';
    $view .= '<a href="delete.php?id=' . $result['id'] . '">';
    $view .= '  [削除]';
    $view .= '</a>';
    $view .="</p>";
  }
}

?>

<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>





