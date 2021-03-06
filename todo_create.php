<?php
// var_dump($_POST);
// exit();
// POSTデータ確認

if (
  !isset($_POST['step01']) || $_POST['step01']==''
  ) {
  exit('データが足りません');
}

$step01 = $_POST['step01'];

// DB接続
include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行（誰かがフォームから入力したものを変数で受け取って、DBに突っ込んでいる。変数は$ではなくて:に変更する）
$sql = 'INSERT INTO task_steps (id, step01, created_at, updated_at) 
VALUES (NULL, :step01, now(), now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':step01', $step01, PDO::PARAM_STR);


// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:todo_read.php");
exit();
?>