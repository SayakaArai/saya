<?php
session_start();

require_once("config/config.php");
require_once("model/User.php");


try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    // SESSION情報を変数へ
      $name = $_SESSION["name"];
      $huri = $_SESSION["huri"];
      $tel = $_SESSION["tel"];
      $email = $_SESSION["email"];
      $adress = $_SESSION["adress"];
      $pass = $_SESSION["pass"];
      $skin = $_SESSION["skin"];
      $color = $_SESSION["color"];
    // xss対策
    function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
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
  referrer()
})
// ダイレクトアクセス対策
function referrer(){
  if (document.referrer.indexOf('add.php') == -1) {
	alert('ページを表示できません')
　window.location.href = 'login.php';
  }else {
  }
}

</script>
</head>
<body>
  <?php
   require("login_menu.php");
  ?>
  <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
 <h2>会員情報 確認</h2>
 <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">


 <form action="add_conp.php" method="post">
   <div id="confirm">
     <?php
        echo "氏名：".h($name)."<br>";
        echo "フリガナ：".h($huri)."<br>";
        echo "電話番号：".h($tel)."<br>";
        echo "メールアドレス：".h($email)."<br>";
        echo "住所：".h($adress)."<br>";
        echo "肌質：".h($skin)."<br>";
        echo "パーソナルカラー：".h($color)."<br>";
     ?>
   </div>
   <input type="hidden" name="name" value="<?php echo $name;?>">
   <input type="hidden" name="huri" value="<?php echo $huri;?>">
   <input type="hidden" name="tel" value="<?php echo $tel;?>">
   <input type="hidden" name="email" value="<?php echo $email;?>">
   <input type="hidden" name="adress" value="<?php echo $adress;?>">
   <input type="hidden" name="pass" value="<?php echo $pass;?>">
   <input type="hidden" name="skin" value="<?php echo $skin;?>">
   <input type="hidden" name="color" value="<?php echo $color;?>">

   <input type="submit" value="送 信" id="submit">
 </form>
  <?php
   require("footer.php");
  ?>

</body>
</html>
