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
// 一般ユーザーの場合、ログインしたユーザー情報を設定する
if($_SESSION['User']['role']==0){
  $result['User']=$_SESSION['User'];
}
try{
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDb();


    // xss対策
    function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
    }

    //参照
    if (isset($_GET['edit'])) {
      $result = $user->findById($_GET['edit']);
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
   require("menu.php");
  ?>
  <div id="dark">
    <div id="main">
      <div class="space">
      </div>

        <img src="img/title_top.png" alt="タイトル飾り上" class="title_top">
        <h2>ご登録内容変更</h2>
        <img src="img/title_under.png" alt="タイトル飾り下" class="title_under">

        <div class="data">

          <form class="" action="edit_conp.php" method="post">
            <table>
              <?php foreach($result as $row):?>
              <tr>
                <th>氏名:</th>
                <td><input type="text" name="name" id="name" value="<?php echo h($row["name"]) ?>"></td>
              </tr>
              <tr>
                <th>フリガナ:</th>
                <td><input type="text" name="huri" id="huri" value="<?php echo h($row["huri"]) ?>"></td>
              </tr>
              <tr>
                <th>電話番号:</th>
                <td><input type="text" name="tel" id="tel" value="<?php echo h($row["tel"]) ?>"></td>
              </tr>
              <tr>
                <th>メールアドレス:</th>
                <td><input type="text" name="email" id="email" value="<?php echo h($row["email"]) ?>"></td>
              </tr>
              <tr>
                <th>住所:</th>
                <td><input type="text" name="adress" id="adress" value="<?php echo h($row["adress"]) ?>"></td>
              </tr>
              <tr>
                <th>パスワード:</th>
                <?php if($_SESSION['User']['role'] ==1): ?>
                  <td><input type="text" name="pass" id="pass" value="<?php echo h($row["pass"]) ?>"></td>
                <?php else: ?>
                  <td><input type="password" name="pass" id="pass" value="<?php echo h($row["pass"]) ?>"></td>
                <?php endif; ?>
              </tr>
              <tr>
                <th>肌質:</th>
                <td>
                  <input type="radio" name="skin" value="乾燥肌"<?php if($row["skin"]=="乾燥肌"){echo 'checked';} ?> class="radio">乾燥肌
                  <input type="radio" name="skin" value="脂性肌"<?php if($row["skin"]=="脂性肌"){echo 'checked';} ?> class="radio">脂性肌
                  <input type="radio" name="skin" value="混合肌"<?php if($row["skin"]=="混合肌"){echo 'checked';} ?> class="radio">混合肌
                  <input type="radio" name="skin" value="普通肌"<?php if($row["skin"]=="普通肌"){echo 'checked';} ?> class="radio">普通肌
                </td>
              </tr>
              <tr>
                <th>パーソナルカラー:</th>
                <td>
                  <input type="radio" name="color" value="春タイプ"<?php if($row["color"]=="春タイプ"){echo 'checked';} ?> class="radio">春タイプ
                  <input type="radio" name="color" value="夏タイプ"<?php if($row["color"]=="夏タイプ"){echo 'checked';} ?> class="radio">夏タイプ
                  <input type="radio" name="color" value="秋タイプ"<?php if($row["color"]=="秋タイプ"){echo 'checked';} ?> class="radio">秋タイプ
                  <input type="radio" name="color" value="冬タイプ"<?php if($row["color"]=="冬タイプ"){echo 'checked';} ?> class="radio">冬タイプ

                </td>
              </tr>
              <input type="hidden" name="id" value="<?=$row["id"] ?>">
            </table>
          <?php endforeach; ?>

            <input type="submit" value="更新" id="submit" >
          </form>

        </div>


    <?php
     require("footer.php");
    ?>
  </div>
</div>


</body>
</html>
