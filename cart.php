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

    //カート参照
    $result = 0;
    $result = $user->cart_view($_SESSION['User']['id']);

     // カート削除
     if (isset($_GET['del'])) {
       $user->carts_del($_GET['del']);
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
<link rel="stylesheet" type="text/css" href="css/cart.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
})
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
        <h2>Cart</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">
      <?php if (!empty($result)):?>
        <form class="" action="cart_conp.php" method="post">
            <table>
              <tr>
                <th>商品</th>
                <th>カラー</th>
                <th>価格</th>
                <th>個数</th>
                <th></th>
              </tr>
            <?php
            $total = 0;
            foreach($result as $row): ?>
              <tr>
                <td><?=$row["products_name"] ?></td>
                <td><?=$row['colortype']?></td>
                <td>￥<?=$row['price']?></td>
                <td><?=$row['num']?></td>
                <td><a href="?del=<?=$row["carts_id"] ?>" onclick="if(!confirm('削除しますがよろしいですか？'))return false">削除</a></td>
              </tr>
              <?php
              $total += $row['subtotal']
              ?>
            <?php endforeach; ?>
              <input type="hidden" name="colortype" value="<?=$row['color_code_id']?>">
              <input type="hidden" name="num" value="<?=$row['num']?>">
              <input type="hidden" name="products_id" value="<?=$row['products_id']?>">

              <tr>
                <th class="total" colspan="5">計 <?=$total ?>円</th>
              </tr>
            </table>
          <input type="submit" name="submit" value="購入" id="submit">
        </form>
      <?php else:?>
      <p>カートに追加された商品はありません</p>
      <?php endif;?>




    <?php
     require("footer.php");
    ?>
  </div>
</div>


</body>
</html>
