
<?php

//データベースの接続をdb_connect.phpファイルで済ませたので、次にデータベースから実際にデータを取得する。
//db接続のファイルと分けた方が分かりやすいので、このindex.phpでデータを取得していく。

//there are 2 ways to get data from db.
//一つはユーザーが入力しないもの　→　「query」　という関数ひとつで取得する。

require 'db_connect.php';

$sql = 'select * from reservations where id = 1';
$stmt = $pdo->query($sql);

$result = $stmt->fetchall();

echo '<pre>';
var_dump($result);
echo '</pre>';


// the other one is for that user do type in.　→　「prepare」、「bind」(bindValue　と　bindParam の２種類ある） 、「execute」の３つの関数を使って取得する
//悪意のある人から入力フォームから攻撃され、データを取られてしまったりしないように、sql文を入力されないように、３つの関数が必要。＋プレスホルダー（sqlインジェクション対策）。

$sql = 'select * from reservations where id = :id';

$stmt = $pdo->prepare($sql);

$stmt->bindValue('id', 2, PDO::PARAM_INT);

$stmt->execute();

$result = $stmt->fetchall();

echo '<pre>';
var_dump($result);
echo '</pre>';

?>


