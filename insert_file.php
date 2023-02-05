<?php
// Excelで登録する場合
require_once(realpath(__DIR__) . "../../vendor/autoload.php");
use PhpOffice\PhpSpreadsheet\IOFactory;

// 送信されたファイルをphpspreadsheet読み込む
$file = $_FILES['file'];
$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load($file['tmp_name']);
$sheet = $spreadsheet->setActiveSheetIndex(0);
$strRange = $sheet->calculateWorksheetDimension(); //ワークシート内の最大領域座標（"A1:XXXnnn" XXX:最大カラム文字列, nnn:最大行）
$data = $sheet->rangeToArray($strRange); // 全データ取得

for ($i = 2; $i<count($data); ++ $i) {
  $book_name = trim($sheet->getCell('A' . $i)->getValue());
  $book_URL = trim($sheet->getCell('B' . $i)->getValue());
  $book_comment = trim($sheet->getCell('C' . $i)->getValue());

  require_once('funcs.php');
  $pdo = db_conn();

  $stmt = $pdo->prepare(
    "INSERT INTO gs_bm_table( id, book_name, book_URL, book_comment, registered_date )
    VALUES( NULL, :book_name, :book_URL, :book_comment, sysdate() )"
  );

  $stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);
  $stmt->bindValue(':book_URL', $book_URL, PDO::PARAM_STR);
  $stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);

  $status = $stmt->execute();

  if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMassage:".$error[2]);
  }else{
    //５．index.phpへリダイレクト
    header("Location: index.php");
  }
}

?>
<!-- 出典：【PHP】Ajaxで送信したExcelをPhpSpreadsheetで読み取る -->
<!-- https://bellsoft.jp/blog/system/detail_525 -->

<!--出典：【php】PhpSpreadsheet 使用例  -->
<!-- https://www.softel.co.jp/blogs/tech/archives/5976 -->
