<?php
require_once("DB.php");
class User extends DB{
  // ログイン
  public function login($arr){
    $sql='SELECT * FROM users WHERE email=:email AND pass=:pass';
    $stmt = $this->connect->prepare($sql);
      $params =array(':email' =>$arr['email'],':pass' =>$arr['pass'] );
      $stmt->execute($params);
      // $result=$stmt->rowcount();
      $result=$stmt->fetch();
      return $result;

  }
  // 参照（条件付き）SELECT
  public function findByColor($id){
    $sql='SELECT * FROM color_code WHERE id=:id';
    $stmt = $this->connect->prepare($sql);
    $params =array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  // 全てのプロフィール参照select
  public function findAll(){
    $sql='SELECT * FROM users';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }
  // プロフィール参照（条件付き）SELECT
  public function findById($id){
    $sql='SELECT * FROM users WHERE id=:id';
    $stmt = $this->connect->prepare($sql);
    $params =array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }


  // 登録insert
  public function add($arr){
    $sql = "INSERT INTO users(name,huri,tel,email,adress,pass,skin,color,role,del) VALUES(:name,:huri,:tel,:email,:adress,:pass,:skin,:color,:role,:del)";
    $stmt = $this->connect->prepare($sql);
    $params = array(':name'=>$arr['name'],
                    ':huri'=>$arr['huri'],
                    ':tel'=>$arr['tel'],
                    ':email'=>$arr['email'],
                    ':adress'=>$arr['adress'],
                    ':pass'=>$arr['pass'],
                    ':skin'=>$arr['skin'],
                    ':color'=>$arr['color'],
                    ':role'=>0,
                    ':del'=>0);
    $stmt->execute($params);
  }
  // 編集update
  public function edit($arr){
    $sql = "UPDATE users SET name=:name,huri=:huri,tel=:tel,email=:email,adress=:adress,pass=:pass,skin=:skin,color=:color WHERE id=:id";
    $stmt = $this->connect->prepare($sql);
      $params = array(':id'=>$arr['id'],
                      ':name'=>$arr['name'],
                      ':huri'=>$arr['huri'],
                      ':tel'=>$arr['tel'],
                      ':email'=>$arr['email'],
                      ':adress'=>$arr['adress'],
                      ':pass'=>$arr['pass'],
                      ':skin'=>$arr['skin'],
                      ':color'=>$arr['color']);
      $stmt->execute($params);
  }

  // 退会delete
  public function delete($id){
    $sql = "UPDATE users SET del=:del WHERE id=:id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id,':del'=>1);
    $stmt->execute($params);
  }


  // 口コミ投稿insert
  public function reviews($arr){
    $sql = "INSERT INTO reviews(users_id,users_skin,users_color,products_id,products_colortype,star,comment,created) VALUES(:users_id,:users_skin,:users_color,:products_id,:products_colortype,:star,:comment,:created)";
    $stmt = $this->connect->prepare($sql);
    $params = array(':users_id'=>$_SESSION['User']['id'],
                    ':users_skin'=>$_SESSION['User']['skin'],
                    ':users_color'=>$_SESSION['User']['color'],
                    ':products_id'=>$arr['id'],
                    ':products_colortype'=>$arr['colortype'],
                    ':star'=>$arr['star'],
                    ':comment'=>$arr['comment'],
                    ':created'=>date('Y-m-d H:i:s'));
    $check=$stmt->execute($params);
   }

  // 参照（口コミ）SELECT
  public function findReview($id){
    $sql="SELECT ";
    $sql .="users.id users_id,";
    $sql .="users.name,";
    $sql .="reviews.users_skin,";
    $sql .="reviews.users_color,";
    $sql .="products.id,";
    $sql .="color_code.colortype,";
    $sql .="reviews.star,";
    $sql .="reviews.comment,";
    $sql .="reviews.created ";
    $sql .="FROM reviews ";
    $sql .="JOIN users ON users.id=reviews.users_id ";
    $sql .="JOIN products ON products.id=reviews.products_id ";
    $sql .="JOIN color_code ON color_code.id=reviews.products_colortype ";
    $sql .="WHERE products.id = :id ";
    $sql .="AND reviews.users_skin = :skin ";
    $sql .="AND reviews.users_color = :color ";
    $sql .="ORDER BY users_id = :users_id DESC";

    $stmt = $this->connect->prepare($sql);
    $params =array(':id' => $id,
                   ':skin' => $_SESSION['User']['skin'],
                   ':color' => $_SESSION['User']['color'],
                   ':users_id' => $_SESSION['User']['id']);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }
  // 管理者参照（口コミ）SELECT
  public function findReviewAdmin($id){
    $sql="SELECT ";
    $sql .="users.id users_id,";
    $sql .="users.name,";
    $sql .="reviews.users_skin,";
    $sql .="reviews.users_color,";
    $sql .="products.id,";
    $sql .="color_code.colortype,";
    $sql .="reviews.star,";
    $sql .="reviews.comment,";
    $sql .="reviews.created ";
    $sql .="FROM reviews ";
    $sql .="JOIN users ON users.id=reviews.users_id ";
    $sql .="JOIN products ON products.id=reviews.products_id ";
    $sql .="JOIN color_code ON color_code.id=reviews.products_colortype ";
    $sql .="WHERE products.id = :id ";

    $stmt = $this->connect->prepare($sql);
    $params =array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }


  // 口コミ削除delete_review
  public function delete_review($created){
      $sql = "DELETE FROM reviews WHERE users_id=:id AND created=:created";
      $stmt = $this->connect->prepare($sql);
      $params =array(':id' => $_SESSION['User']['id'],
                     ':created' => $created );
      $stmt->execute($params);
    }

    // カートinsert
    public function cart($arr){
      $sql = "INSERT INTO carts(users_id,products_id,colortype,num,created) VALUES(:users_id,:products_id,:colortype,:num,:created)";
      $stmt = $this->connect->prepare($sql);
      $params = array(':users_id'=>$_SESSION['User']['id'],':products_id'=>$arr['products_id'],':colortype'=>$arr['colortype'],':num'=>$arr['num'],':created'=>date('Y-m-d'));
      $stmt->execute($params);
    }


    // カート参照 SELECT
    public function cart_view($id){
      $sql="SELECT ";
      $sql .="users.id,";
      $sql .="products.id products_id,";
      $sql .="products.name products_name,";
      $sql .="products.price,";
      $sql .="color_code.colortype,";
      $sql .="color_code.id color_code_id,";
      $sql .="carts.num,";
      $sql .="carts.carts_id,";
      $sql .="carts.created,";
      $sql .="products.price * carts.num  subtotal ";
      $sql .="FROM carts ";
      $sql .="JOIN users ON users.id=carts.users_id ";
      $sql .="JOIN products ON products.id=carts.products_id ";
      $sql .="JOIN color_code ON color_code.id=carts.colortype ";
      $sql .="WHERE users.id = :id";

      $stmt = $this->connect->prepare($sql);
      $params =array(':id' => $id);
      $stmt->execute($params);
   //    echo "\nPDOStatement::errorInfo():\n";
   // $ar = $stmt->errorInfo();
   // print_r($ar);
      $result = $stmt->fetchAll();
      return $result;
    }
    // カート全削除carts_all_del
    public function carts_all_del(){
      $sql = "DELETE FROM carts WHERE created < DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
      $stmt = $this->connect->query($sql);
      }
    // カート購入後削除carts_register_del
    public function carts_register_del(){
      $sql = "DELETE FROM carts";
      $stmt = $this->connect->prepare($sql);
      $stmt->execute();
      }

      // カート削除carts_del
      public function carts_del($id){
          $sql = "DELETE FROM carts WHERE carts_id=:id";
          $stmt = $this->connect->prepare($sql);
          $params =array(':id' => $id);
          $stmt->execute($params);
        }


    // 購入insert
    public function registerProduct($arr){
      $sql = "INSERT INTO users_products(users_id,products_id,colortype,num,created) VALUES(:users_id,:products_id,:colortype,:num,:created)";
      $stmt = $this->connect->prepare($sql);
      $params = array(':users_id'=>$_SESSION['User']['id'],':products_id'=>$arr['products_id'],':colortype'=>$arr['colortype'],':num'=>$arr['num'],':created'=>date('Y-m-d H:i:s'));
      $stmt->execute($params);

    }


  // 参照（購入履歴）SELECT
  public function orderHistory($id){
    $sql="SELECT ";
    $sql .="users.id,";
    $sql .="products.id,";
    $sql .="products.name products_name,";
    $sql .="products.price,";
    $sql .="users_products.num,";
    $sql .="users_products.created ";
    $sql .="FROM users_products ";
    $sql .="JOIN users ON users.id=users_products.users_id ";
    $sql .="JOIN products ON products.id=users_products.products_id ";
    $sql .="WHERE users_id = :id ";
    $sql .="AND users_products.created >= NOW()- INTERVAL 1 MONTH ";
    $sql .="ORDER BY users_products.created DESC";

    $stmt = $this->connect->prepare($sql);
    $params =array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
   //  echo "\nPDOStatement::errorInfo():\n";
   // $ar = $stmt->errorInfo();
   // print_r($ar);

 }
  // 管理者参照（購入履歴）SELECT
  public function orderHistoryAdmin(){
    $sql="SELECT ";
    $sql .="users.id users_id,";
    $sql .="users.name users_name,";
    $sql .="products.id products_id,";
    $sql .="products.name products_name,";
    $sql .="products.price,";
    $sql .="users_products.num,";
    $sql .="users_products.created ";
    $sql .="FROM users_products ";
    $sql .="JOIN users ON users.id=users_products.users_id ";
    $sql .="JOIN products ON products.id=users_products.products_id ";
    $sql .="ORDER BY users_products.created DESC";

    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
   //  echo "\nPDOStatement::errorInfo():\n";
   // $ar = $stmt->errorInfo();
   // print_r($ar);

  }



  // 入力チェック
  public function validate($arr){
    $message = array();

    // ユーザー名
    if(empty($arr['name'])){
      $message['name']='ユーザー名を入力してください。';
    }
    // フリガナ
    if(empty($arr['huri'])){
      $message['huri']='フリガナを入力してください。';
    }

    // 電話番号
    if(empty($arr['tel'])){
      $message['tel']='電話番号を入力してください。';
    }

    // メールアドレス
    if(empty($arr['email'])){
      $message['email']='メールアドレスを入力してください。';
    }
    else{
      if (!filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) {
        $message['email']='メールアドレスが正しくありません。';
      }
    }

    //住所
    if(empty($arr['adress'])){
      $message['adress']='住所を入力してください。';
    }
    // パスワード
    if(empty($arr['pass'])){
      $message['pass']='パスワードを入力してください。';
    }
    // 肌質
    if(empty($arr['skin'])){
      $message['skin']='肌質を入力してください。';
    }
    // パーソナルカラー
    if(empty($arr['color'])){
      $message['color']='パーソナルカラーを入力してください。';
    }
  return $message;
}


}
