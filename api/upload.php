<?php
// 関数ファイル読み込み
include('functions.php');
header('Access-Control-Allow-Origin: *');

// var_dump($_POST);
// var_dump($_FILES);
// exit();

// Fileアップロードチェック
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // ファイルをアップロードしたときの処理
  // アップロードしたファイルの情報取得
  $uploadedFileName = $_FILES['upfile']['name'];     //アップロードしたファイルのファイル名
  $tempPathName  = $_FILES['upfile']['tmp_name'];    //アップロード先のTempフォルダ
  $fileDirectoryPath = 'upload/';                    //画像ファイル保管先のディレクトリ名，自分で設定する
  //File名の変更
  $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);              //拡張子取得
  $uniqueName = date('YmdHis') . md5(session_id()) . "." . $extension;       //ユニークファイル名作成
  $savedFileName = $fileDirectoryPath . $uniqueName;                         //ファイル名とパス
  // FileUpload開始
  if (is_uploaded_file($tempPathName)) {
    if (move_uploaded_file($tempPathName, $savedFileName)) {
      chmod($savedFileName, 0644);
    } else {
      echo json_encode(['error' => 'アップロードできませんでした']);
      http_response_code(500);
      exit();
    }
  } else {
    echo json_encode(['error' => 'ファイルが見つかりません']);
    http_response_code(500);
    exit();
  }
  // FileUpload終了
} else {
  // ファイルをアップしていないときの処理
  // ファイルパスは空文字にしておく
  $savedFileName = '';
}

// 必須項目のチェック
if (
  !isset($_POST['task']) || $_POST['task'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  echo json_encode(['error' => 'param error']);
  http_response_code(500);
  exit();
}

$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];

// DB接続
$pdo = connectToDb();

// データ登録SQL作成
$sql = 'INSERT INTO todo_table(id, task, deadline, comment, image, created_at, updated_at) VALUES(NULL, :task, :deadline, :comment, :image, sysdate(), sysdate())';

// SQL実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':task', $task, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':image', $savedFileName, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  showSqlErrorMsg($stmt);
} else {
  echo json_encode(['msg' => 'Upload successful!']);
  exit();
}
