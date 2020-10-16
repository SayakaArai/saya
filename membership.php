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
if(!isset($_SESSION['User'])|| $_SESSION['User']['del']==1){
  header('Location:/cosme/login.php');
  exit;
}
// 一般ユーザーの場合、ログインしたユーザー情報を設定する
if($_SESSION['User']['role']==0){
  $result['User']=$_SESSION['User'];
}

try{
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDb();

  // 参照
  if($_SESSION['User']['role']===0){
    // 特定のプロフィール
    $result = $user->findById($_SESSION['User']['id']);
  }elseif($_SESSION['User']['role'] != 0) {
     // 全てのプロフィール
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
        <h2>MEMBERSHIP</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

        <div class="data">
          <?php foreach($result as $row):?>
            <table>
              <tr>
                <th>氏名:</th>
                <td><?=$row['name'] ?></td>
              </tr>
              <tr>
                <th>フリガナ:</th>
                <td><?php echo $row["huri"] ?></td>
              </tr>
              <tr>
                <th>電話番号:</th>
                <td><?php echo $row["tel"] ?></td>
              </tr>
              <tr>
                <th>メールアドレス:</th>
                <td><?php echo $row["email"] ?></td>
              </tr>
              <tr>
                <th>住所:</th>
                <td><?php echo $row["adress"] ?></td>
              </tr>
              <tr>
                <th>パスワード:</th>
                <?php if($_SESSION['User']['role'] ==1): ?>
                  <td><?php echo $row["pass"] ?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
              </tr>
              <tr>
                <th>肌質:</th>
                <td><?php echo $row["skin"] ?></td>
              </tr>
              <tr>
                <th>パーソナルカラー:</th>
                <td><?php echo $row["color"] ?></td>
              </tr>
            </table>

          <div class="button">
            <a href="edit.php?edit=<?php echo $row['id']?>">変更する</a>
            <a href="delete_conp.php?del=<?php echo $row['id']?>"  onclick="if(!confirm('退会しますがよろしいですか？'))return false">退会する</a>
          </div>
        <?php endforeach; ?>
        </div>


    <?php
     require("footer.php");
    ?>
  </div>
</div>

</body>
</html>
