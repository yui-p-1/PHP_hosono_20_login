<!-- Excelファイルでダウンロード -->
<?php
$connect = mysqli_connect("localhost", "root", "", "gs_db", 8111);

if(isset($_POST["submit"]))
{
 $query = "SELECT * FROM gs_bm_table";
 $res = mysqli_query($connect, $query);

 if(mysqli_num_rows($res) > 0)
 {
//  $export =pack('C*', 0xEF, 0xBB, 0xBF);
 $export = "";
 $export .= '
 <table> 
 <tr> 
 <th>registered_date</th>
 <th>book_name</th> 
 <th>book_URL</th> 
 <th>book_comment</th> 
 </tr>
 ';
 while($row = mysqli_fetch_array($res))
 {
 $export .= '
 <tr>
 <td>'.$row["registered_date"].'</td> 
 <td>'.$row["book_name"].'</td> 
 <td>'.$row["book_URL"].'</td> 
 <td>'.$row["book_comment"].'</td> 
 </tr>
 ';
 }

$export .= '</table>';
$export = mb_convert_encoding($export,"SJIS-win", "UTF-8");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="output.xls');
echo $export;
exit;
//  チャレンジ



 }
}
// 出典：PHP で MySQL テーブルを Excel にエクスポート
// https://www.delftstack.com/ja/howto/php/php-export-to-excel/
?>

