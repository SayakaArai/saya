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

    if($_SESSION['User']['role'] == 0){
    // 購入履歴
     $result = $user->orderHistory($_SESSION['User']['id']);
   }elseif($_SESSION['User']['role'] != 0) {
     // 全ての購入履歴
      $result = $user->orderHistoryAdmin();
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
<link rel="stylesheet" type="text/css" href="css/orderhistory.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
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
        <h2>ORDER HISTORY</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">
        <?php if (!empty($result)):?>
             <table>
               <tr>
               <?php if($_SESSION['User']['role'] !=0):?>
                 <th>ユーザid</th>
                 <th>ユーザ名</th>
               <?php endif;?>
                 <th>商品名</th>
                 <th>価格</th>
                 <th>個数</th>
                 <th>購入日</th>
               </tr>

               <?php foreach($result as $row): ?>
                 <tr>
                   <?php if($_SESSION['User']['role'] !=0):?>
                     <td><?=$row['users_id'] ?></td>
                     <td><?=$row['users_name'] ?></td>
                   <?php endif;?>

                   <td><?=$row['products_name'] ?></td>
                   <td>￥<?=$row['price'] ?></td>
                   <td><?=$row['num'] ?></td>
                   <th><?=date('Y/m/d', strtotime($row['created']))?></th>
                 </tr>
              <?php endforeach; ?>
             </table>
           <?php else:?>
           <p>購入履歴はありません</p>
           <?php endif;?>



    <?php
     require("footer.php");
    ?>
  </div>
</div>


</body>
</html>
