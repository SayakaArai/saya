<?php
session_start();

require_once("config/config.php");
require_once("model/User.php");

// PDO接続
try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();
    // 登録処理
    if($_POST){
      $message = $user->validate($_POST);
      if(empty($message['name'])
      && empty($message['huri'])
      && empty($message['tel'])
      && empty($message['email'])
      && empty($message['adress'])
      && empty($message['pass'])
      && empty($message['skin'])
      && empty($message['color'])){
       $_SESSION = $_POST;
       header('Location:/cosme/add_conf.php');
       exit;
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
<title>Shiny cosmesite</title>
<link rel="stylesheet" type="text/css" href="css/require.css">
<link rel="stylesheet" type="text/css" href="css/add.css">
<link rel="icon" href="img/favicon.jpg" type="image/jpg">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(function(){
  popup()
  referrer()
})
function popup(){
  $('span').on('click',function(){
  $('.popup').addClass('show').fadeIn();
})

$('#close').on('click',function(){
  $('.popup').fadeOut();
})
}
// // ダイレクトアクセス対策
// function referrer(){
//   if (document.referrer.indexOf('login.php') == -1 ) {
// 	alert('ページを表示できません')
// 　window.location.href = 'login.php';
//   }else {
//   }
// }

// function check() {
//     if(document.getElementById("name").value === "") {
//         alert("氏名を入力してください");
//         return false;
//     }
//     if(document.getElementById("huri").value === "") {
//         alert("フリガナを入力してください");
//         return false;
//     }
//     if(document.getElementById("tel").value === "") {
//         alert("電話番号を入力してください。");
//         return false;
//     }
//     if(document.getElementById("email").value === "") {
//         alert("メールアドレスを入力してください");
//         return false;
//     }
//     if (!filter_var(getElementById('email'), FILTER_VALIDATE_EMAIL)) {
//       alert("メールアドレスが正しくありません");
//       return false;
//     }
//
//     if(document.getElementById("address").value === "") {
//         alert("住所を入力してください。");
//         return false;
//     }
//     if(document.getElementById("skin").value === "") {
//         alert("肌質を選択してください");
//         return false;
//     }
//     if(document.getElementById("color").value === "") {
//         alert("パーソナルカラーを選択してください");
//         return false;
//     }
// }

</script>
</head>
<body>
  <?php
   require("login_menu.php");
  ?>
  <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
 <h2>新規会員登録</h2>
 <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

 <?php if(isset($message)){
   foreach ($message as $value) {
     echo "<P class='error'>".$value."</P>";
   }
 }  ?>

 <form name="form" action="" method="post">
    <table>
      <tr>
       <th>氏名:</th>
       <td><input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) echo  htmlspecialchars($_POST['name'], ENT_QUOTES,'UTF-8')?>"></td>
      </tr>
      <tr>
       <th>フリガナ:</th>
       <td><input type="text" name="huri" id="huri" value="<?php if(isset($_POST['huri'])) echo  htmlspecialchars($_POST['huri'], ENT_QUOTES,'UTF-8')?>"></td>
      </tr>
      <tr>
        <th>電話番号:</th>
        <td><input type="text" name="tel" id="tel" value="<?php if(isset($_POST['tel'])) echo htmlspecialchars($_POST['tel'], ENT_QUOTES,'UTF-8')?>" ></td>
      </tr>
      <tr>
        <th>メールアドレス:</th>
        <td><input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES,'UTF-8')?>" ></td>
      </tr>
      <tr>
        <th>住所:</th>
        <td><input type="text" name="adress" id="adress" value="<?php if(isset($_POST['adress'])) echo htmlspecialchars($_POST['adress'], ENT_QUOTES,'UTF-8')?>" ></td>
      </tr>
      <tr>
        <th>パスワード:</th>
        <td><input type="password" name="pass" id="pass" value="<?php if(isset($_POST['pass'])) echo htmlspecialchars($_POST['pass'], ENT_QUOTES,'UTF-8')?>"  ></td>
      </tr>
      <tr>
        <th>※肌質:</th>
        <td>
          <input type="radio" name="skin" value="乾燥肌"<?php if(isset($_POST['skin'])) if(htmlspecialchars($_POST['skin'], ENT_QUOTES,'UTF-8')  == "乾燥肌"){echo "checked";} ?> class="radio">乾燥肌
          <input type="radio" name="skin" value="脂性肌"<?php if(isset($_POST['skin'])) if(htmlspecialchars($_POST['skin'], ENT_QUOTES,'UTF-8')  == "脂性肌"){echo "checked";} ?> class="radio">脂性肌
          <input type="radio" name="skin" value="混合肌"<?php if(isset($_POST['skin'])) if(htmlspecialchars($_POST['skin'], ENT_QUOTES,'UTF-8')  == "混合肌"){echo "checked";} ?> class="radio">混合肌
          <input type="radio" name="skin" value="普通肌"<?php if(isset($_POST['skin'])) if(htmlspecialchars($_POST['skin'], ENT_QUOTES,'UTF-8')  == "普通肌"){echo "checked";} ?> class="radio">普通肌

        </td>
      </tr>
      <tr>
        <th>※パーソナルカラー:</th>
        <td>
          <input type="radio" name="color" value="春タイプ"<?php if(isset($_POST['color'])) if(htmlspecialchars($_POST['color'], ENT_QUOTES,'UTF-8')  == "春タイプ"){echo "checked";} ?> class="radio">春タイプ
          <input type="radio" name="color" value="夏タイプ"<?php if(isset($_POST['color'])) if(htmlspecialchars($_POST['color'], ENT_QUOTES,'UTF-8')  == "夏タイプ"){echo "checked";} ?> class="radio">夏タイプ
          <input type="radio" name="color" value="秋タイプ"<?php if(isset($_POST['color'])) if(htmlspecialchars($_POST['color'], ENT_QUOTES,'UTF-8')  == "秋タイプ"){echo "checked";} ?> class="radio">秋タイプ
          <input type="radio" name="color" value="冬タイプ"<?php if(isset($_POST['color'])) if(htmlspecialchars($_POST['color'], ENT_QUOTES,'UTF-8')  == "冬タイプ"){echo "checked";} ?> class="radio">冬タイプ
        </td>
      </tr>
    </table>

    <p class="new">※肌質・パーソナルカラーがわからない方は、<span>こちら</span>からお確かめください。</p>

    <div class="popup">
      <ul>
        <li>
          <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
          <h2>肌質診断</h2>
          <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">
          <img src="img/skin_check.jpg" alt="肌診断" class="chart">
        </li>
        <li>
          <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
          <h2>パーソナルカラー診断</h2>
          <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

          <img src="img/color_check.jpg" alt="カラー診断" class="chart">
        </li>
      </ul>

      <p id="close">閉じる</p>
    </div>

    <input type="submit" value="送 信" id="submit" onclick="return check()">
 </form>

  <?php
   require("footer.php");
  ?>

</body>
</html>
