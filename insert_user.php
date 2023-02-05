<?php
//1. POSTデータ取得
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_comment = $_POST["user_comment"];
$id = $_POST["id"];

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare( "UPDATE gs_bm_table SET user_name = :user_name, user_email = :user_email, user_comment = :user_comment WHERE id = :id;" );

$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':user_email', $user_email, PDO::PARAM_STR);
$stmt->bindValue(':user_comment', $user_comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
} else {
    redirect('management.php');
}
?>