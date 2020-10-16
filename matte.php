<?php

require_once("config/config.php");
require_once("model/User.php");

session_start();

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

    // カートに追加
     if (isset($_POST['buy'])) {
        $result1  = $user->cart($_POST['buy']);
        $_SESSION['Cart'] = $result1;
     }

    // 口コミ投稿
    if(isset($_POST['review'])){
      $user->reviews($_POST['review']);
    }
    // 口コミ参照
    if(isset($_GET['id'])){
      if ($_SESSION['User']['role']==0) {
        $result = $user->findReview($_GET['id']);
      }elseif ($_SESSION['User']['role']==1) {
        $result = $user->findReviewAdmin($_GET['id']);
      }
    }
    // 口コミ削除
    if(isset($_GET['del'])){
      $user->delete_review($_GET['del']);
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
<link rel="stylesheet" type="text/css" href="css/matte.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
  search_menu()
  slide_animate()
  border()
})
function search_menu(){
  $('#search').on('click',function(){
  $('#search_form').fadeIn()
})

  $('#close').on('click',function(){
    $('#search_form').fadeOut()
  })
}
function slide_animate(){
  $('#photo ul li').eq(0).on('click',function(){
    $('#main_photo ul').animate({marginLeft:'0px'})
    $('#name ul').animate({marginLeft:'0px'})
    $('#spinner ul').animate({marginLeft:'0px'})
  })
  $('#photo ul li').eq(1).on('click',function(){
    $('#main_photo ul').animate({marginLeft:'-300px'})
    $('#name ul').animate({marginLeft:'-160px'})
    $('#spinner ul').animate({marginLeft:'-180px'})
  })
  $('#photo ul li').eq(2).on('click',function(){
    $('#main_photo ul').animate({marginLeft:'-600px'})
    $('#name ul').animate({marginLeft:'-320px'})
    $('#spinner ul').animate({marginLeft:'-360px'})
  })
  $('#photo ul li').eq(3).on('click',function(){
    $('#main_photo ul').animate({marginLeft:'-900px'})
    $('#name ul').animate({marginLeft:'-480px'})
    $('#spinner ul').animate({marginLeft:'-540px'})
  })
}

function border(){
  $('#photo ul li').on('click',function(){
    $('#photo ul li').removeClass('border')
    $(this).addClass('border')
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
      <div class="space">
      </div>

      <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
      <h2>Double Lasting Foundaition</h2>
      <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

      <div class="flex">
        <div class="space">
        </div>
        <div id="main_photo">
          <ul>
            <li><img src="img/product/matte/matte_foundation.jpg" alt="マットメイン画像"></li>
            <li><img src="img/product/matte/matte_Petal.jpg" alt="ペタル"></li>
            <li><img src="img/product/matte/matte_NeutralBeige.jpg" alt="ニュートラルベージュ"></li>
            <li><img src="img/product/matte/matte_Beige.jpg" alt="ベージュ"></li>
          </ul>
        </div>
        <div id="spinner">
             <ul>
               <li class="space"></li>
               <li>
                 <form  action="" method="post">
                   <table>
                     <tr>
                       <th>￥2,000</th><td><input type="number" value="1"  max="10" min="1" name="buy[num]"></td>
                     </tr>
                   </table>
                   <input type="hidden" name="buy[colortype]" value="1">
                   <input type="hidden" name="buy[products_id]" value="1">
                   <input type="submit" name="submit" id="submit" value="カートに追加"　onclick="if(!confirm('追加してよろしいですか？'))return false">
                 </form>
               </li>
               <li>
                 <form  action="" method="post">
                   <table>
                     <tr>
                       <th>￥2,000</th><td><input type="number" value="1"  max="10" min="1" name="buy[num]"></td>
                     </tr>
                   </table>
                   <input type="hidden" name="buy[colortype]" value="2">
                   <input type="hidden" name="buy[products_id]" value="1">
                   <input type="submit" name="submit" id="submit" value="カートに追加"　onclick="if(!confirm('追加してよろしいですか？'))return false">
                 </form>
               </li>
               <li>
                 <form  action="" method="post">
                   <table>
                     <tr>
                       <th>￥2,000</th><td><input type="number" value="1"  max="10" min="1" name="buy[num]"></td>
                     </tr>
                   </table>
                   <input type="hidden" name="buy[colortype]" value="3">
                   <input type="hidden" name="buy[products_id]" value="1">
                   <input type="submit" name="submit" id="submit" value="カートに追加"　onclick="if(!confirm('追加してよろしいですか？'))return false">
                 </form>
               </li>
             </ul>
           </div>
         </div>

      <div id="name">
        <ul>
          <li></li>
          <li><p>Petal</p></li>
          <li><p>NeutralBeige</p></li>
          <li><p>Beige</p></li>
        </ul>
      </div>

      <div id="photo">
        <ul>
          <li class="border"><img src="img/product/matte/matte_foundation.jpg" alt="マットメイン画像"></li>
          <li><img src="img/product/matte/matte_Petal.jpg" alt="ペタル"></li>
          <li><img src="img/product/matte/matte_NeutralBeige.jpg" alt="ニュートラルベージュ"></li>
          <li><img src="img/product/matte/matte_Beige.jpg" alt="ベージュ"></li>
        </ul>
      </div>

      <div id="text">
        <p class="index">肌に密着し美しさをキープ</p>
        <p>付けた瞬間、肌にピタッと留まる“マグネットフィットエフェクト”でムラなく密着します。<br>
          あらゆる表情の動きにフィットし、テカリ・皮脂による化粧崩れ・乾燥を防ぎ、つけたての美しさを24時間キープします。</p>
      </div>
      <div id="makeup">
        <img src="img/product/matte/matte_make1.jpg" alt="見本1">
        <img src="img/product/matte/matte_make2.jpg" alt="見本2">
      </div>

      <div id="review_insert">
        <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
        <h2>Review</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

        <p class="index">◆口コミを投稿する◆</p>
        <form class="" action="" method="post">
          <table>
            <tr>
              <th>カラー：</th>
              <td>
                <input type="radio" name="review[colortype]" value="1" class="radio">ペタル
                <input type="radio" name="review[colortype]" value="2" class="radio">ニュートラルベージュ
                <input type="radio" name="review[colortype]" value="3" class="radio">ベージュ
              </td>
            </tr>
            <tr>
              <th>評価　：</th>
              <td>
                <select name="review[star]">
                  <option value="5">★★★★★</option>
                  <option value="4">★★★★</option>
                  <option value="3">★★★</option>
                  <option value="2">★★</option>
                  <option value="1">★</option>
                </select>
              </td>
            </tr>
          </table>
          <div id="textarea">
            <textarea name="review[comment]" id="comment"></textarea>
          </div>
          <input type="hidden" name="review[id]" value="1">

          <input type="submit" name="submit" value="投稿" id="submit">

        </form>
      </div>

      <div id="review">
        <?php foreach($result as $row): ?>
        <table>
          <tr>
            <td class="star"><?php
            if($row["star"] == 5) {
              echo "★★★★★";
            }
            if($row["star"] == 4) {
               echo "★★★★";
            }
            if($row["star"] == 3) {
               echo "★★★";
            }
            if($row["star"] == 2) {
               echo "★★";
            }
            if($row["star"] == 1) {
               echo "★";
            }
            ?></td>
            <td class="created"><?=$row["created"] ?></td>
            <td class="name"><?=$row["name"] ?></td>
            <td class="users_skin"><?=$row["users_skin"] ?></td>
            <td class="users_color"><?=$row["users_color"] ?></td>
          </tr>
          <tr>
            <td class="colortype"><?=$row["colortype"] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <?php if($_SESSION['User']['id'] == $row["users_id"] ||$_SESSION['User']['role']==1):?>
            <td class="del"><a href="?del=<?=$row["created"] ?>&id=1" onclick="if(!confirm('削除しますがよろしいですか？'))return false">削除</a></td>
            <?php endif;?>
          </tr>
          <tr>
            <td colspan="5"><?=$row["comment"] ?></td>
          </tr>
        </table>
        <?php endforeach; ?>

      </div>
    <?php
     require("footer.php");
    ?>
  </div>

</div>


</body>
</html>
