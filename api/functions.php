<?php
// DB接続関数（PDO）
function connectToDb()
{
  $dbn = 'mysql:dbname=gsacfd05_02;charset=utf8;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';
  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    exit('dbError:' . $e->getMessage());
  }
}

// SQL処理エラー
function showSqlErrorMsg($stmt)
{
  $error = $stmt->errorInfo();
  echo json_encode($error[2]);
  http_response_code(500);
  exit();
}

function check_session_id()
{
  if(
    !isset($_SESSION["session_id"])||
    $_SESSION["session_id"]!=session_id()
  ){
    header("Location:login.php");
  }else{
    session_regenerate_id(true);
    $_SESSION['session_id']=session_id();
  }
}
