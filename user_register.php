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
  <nav class="navbar navbar-default" style="background-color:gray">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="management.php">user register</a></div>
    <!-- hrefの部分、要検討 -->
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert_user.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー登録</legend>
    <label>ユーザーid：<?= $result["id"] ?></label><br>
     <label>ユーザー名：<input type="text" name="user_name" value="<?= $result["user_name"] ?>"></label><br>
     <label>e-mail：<input type="text" name="user_email" value="<?= $result["user_email"] ?>"></label><br>
     <label>コメント：<textArea name="user_comment" rows="4" cols="40"><?= $result["user_comment"] ?></textArea></label><br>
     <input type="hidden" name="id" value="<?= $result['id'] ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>

<!-- Main[End] -->

</body>
</html>