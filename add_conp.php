<?php

require_once("config/config.php");
require_once("model/User.php");

// ダイレクトアクセス対策
if(!isset($_POST["name"])) {
  header('Location: /cosme/login.php');
  exit();
}

try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    // 登録処理
    // 前のページでポスト送信された情報が飛んできてる
    if($_POST) {
      $user->add($_POST);
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
<title>Shiny cosmesite</title>
<link rel="stylesheet" type="text/css" href="css/require.css">
<link rel="stylesheet" type="text/css" href="css/add.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
})

</script>
</head>
<body>
  <?php
   require("login_menu.php");
  ?>
  <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
 <h2>登録完了</h2>
 <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

<p>ご登録ありがとうございます。<br>
ショッピングをお楽しみください。</p>

<p><a href="index.php">rログイン画面へ</a></p>

  <?php
   require("footer.php");
  ?>

</body>
</html>
