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
if(!isset($_SESSION['User']) || $_SESSION['User']['del']==1){
  header('Location:/cosme/login.php');
  exit;
}
// 一般ユーザーの場合、ログインしたユーザー情報を設定する
if($_SESSION['User']['role']==0){
  $result['User']=$_SESSION['User'];
}
// PDO接続
try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

     //1日経ったらすべてのカートの中身を削除
    $user->carts_all_del();
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
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
  search_menu()
  top_movie()
  slide()
})
function search_menu(){
  $('#search').on('click',function(){
  $('#search_form').fadeIn();
});

  $('#close').on('click',function(){
    $('#search_form').fadeOut();
  });
}
function top_movie(){
  $('#movie1').fadeIn(2000,function(){
    $(this).delay(4000).fadeOut(2000,function(){
      $('#movie2').fadeIn(2000,function(){
        $(this).delay(4000).fadeOut(2000)
        setTimeout(top_movie,6000)
      })
    })
  })
}
function slide(){
  $('#next').on('click',function(){
    $('#pickup_photo ul').animate({marginLeft: '-660px'})
  })
  $('#prev').on('click',function(){
    $('#pickup_photo ul').animate({marginLeft: '0px'})
  })
}
</script>
</head>
<body>
  <?php
   require("menu.php");
  ?>
  <div id="dark">
    <div id="main">
        <div id="movie1">
          <p>あなただけの煌めきを</p>
        </div>
        <div id="movie2">
          <p>Shiny</p>
        </div>

        <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
        <h2>LINEUP</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

        <div id="pickup_area">
          <img src="img/thumb_prev.png" alt="左" id="prev">
          <div id="pickup_photo">
            <ul>
              <li><a href="matte.php?id=1"><img src="img/product/matte/matte_foundation.jpg" alt="マットファンデ"></a></li>
              <li><img src="img/product/glossy/glossy_foundation.jpg" alt="つやファンデ"></li>
              <li><img src="img/product/lipstick/lipstick.jpg" alt="リップスティック"></li>
              <li><img src="img/product/liptint/liptint.jpg" alt="リップティント"></li>
              <li><img src="img/product/cheek/cheek.jpg" alt="チーク"></li>
              <li><img src="img/product/eyeshadow/eyeshadow.jpg" alt="アイシャドウ"></li>

            </ul>
          </div>
          <img src="img/thumb_next.png" alt="右" id="next">
        </div>


    <?php
     require("footer.php");
    ?>
  </div>
</div>


</body>
</html>
