<?php
session_start();
require_once("config/config.php");
require_once("model/User.php");

// ログアウト処理
if(isset($_GET['logout'])){
  // セッション情報を破棄する
  $_SESSION = array();
  session_destroy();
}

// ログイン画面を経由しているか確認
if(!isset($_SESSION['User'])){
  header('Location:/cosme/login.php');
  exit;
}
try{
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDb();

  // 削除処理
  if (isset($_GET{'del'})) {
    $user->delete($_GET['del']);

  }


    // 参照処理
    if($_SESSION['User']['role'] !=0){
      $result = $user->findAll();
    }


}catch (PDOException $e) { // PDOExceptionをキャッチする
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
<link rel="stylesheet" type="text/css" href="css/membership.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
  referrer()
})

function referrer(){
  if (document.referrer.indexOf('membership') == -1) {
	alert('ページを表示できません')
　window.location.href = 'membership.php';
  }else {
  }
}

</script>
</head>
<body>
  <?php
   require("login_menu.php");
  ?>
  <div id="dark">
    <div id="main">
      <div class="space">
      </div>

        <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
        <h2>退会完了</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

        <p>退会が完了しました。<br>
           またのご利用お待ちしております。</p>

        <p><a href="login.php">ログイン画面へ</a></p>


    <?php
     require("footer.php");
    ?>
  </div>
</div>


</body>
</html>
