<?php
session_start();

require_once("config/config.php");
require_once("model/User.php");

try{
  $contacts = new User($host,$dbname,$user,$pass);
  $contacts->connectDb();

  if($_POST){
    $result = $contacts->login($_POST);
    if(!empty($result) && $result['del']==0){
      $_SESSION['User'] = $result;
      header('Location:/cosme/index.php');
      exit;
    }else {
      $message= "ログインできません";

    }
  }
}
catch (PDOException $e) { // PDOExceptionをキャッチする
    print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ログイン画面</title>
<link rel="stylesheet" type="text/css" href="css/require.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">

</head>
<body>
  <?php
   require("login_menu.php");
  ?>
  <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
  <h2>Login</h2>
  <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

  <p id="login">ログインするには以下にメールアドレスとパスワードを入力してください。</p>
  <?php if(isset($message)) echo "<p class='error'>".$message."</p>"?>

  <form action="" method="post">
    <table border="1">
      <tr>
        <th>メールアドレス</th>
        <td><input type="text" name="email"></td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td><input type="password" name="pass"></td>
      </tr>
    </table>
    <input type="submit" value="送信" id="login_submit">
  </form>

  <p class="new">新規会員登録は<a href="add.php">こちら</a></p>

  <footer>
    <div class="line"></div>
  </footer>

</body>
</html>
