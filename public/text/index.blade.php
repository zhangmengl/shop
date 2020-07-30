<?php
// $config = [
//     'host' => '127.0.0.1',   //iP地址
//     'port' => '3306',   //端口
//     'dbname' => 'shop',   //数据库名字
//     'user' => 'root',   //用户名
//     'pass' => 'rootroot'   //密码
// ];

// $dbh = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}",$config['user'],$config['pass']);
try{
 	$pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=shop","root","rootroot");
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    $sql = "select * from p_users where user_name=:user_name and password=:password";
    // echo "$sql";

    //预处理  参数绑定
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_name',$user_name);
    $stmt->bindParam(':password',$password);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($res);

}catch (PDOException $e){
	echo "数据库连接失败：".$e->getMessage();
}




?>
