<?php
include_once("../admin/config.php");
if (!isset($_SESSION)) {
    session_start();
}
$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
$checkcode = strtolower(isset($_REQUEST['checkcode']) ? $_REQUEST['checkcode'] : '');

if ($checkcode !== strtolower($_SESSION['vcode'])) {
    $re['result'] = 'fail';
    $re['reason'] = '验证码错误';
} else if (empty($username)) {
    $re['result'] = 'fail';
    $re['reason'] = '用户名不能为空'; 
} else if (empty($password)) {
    $re['result'] = 'fail';
    $re['reason'] = '密码不能为空'; 
} else {
    $pdo = new PDO("mysql:host=" . MYSQL_SERVER . ";dbname=bitrobot", MYSQL_USERNAME, MYSQL_PASSWORD);
    
    $username = $pdo->quote($username);
    $password = $pdo->quote($password);
    
    if (!$username || !$password) {
        $re['result'] = 'fail';
        $re['reason'] = '请求非法';  
    } else {
        $sql = "SELECT * FROM " . MYSQL_PREFIX . "user WHERE username={$username} AND password={$password}";
        $result = $pdo->query($sql);
        if ($result == false ) {
            $re['result'] = 'fail';
            $re['reason'] = '服务器错误，请联系管理员';
        } else {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if (empty($user)) {
                $re['result'] = 'fail';
                $re['reason'] = '用户名或密码错误';
            } else { // 登录成功
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['logintime'] = time();
                $re['result'] = 'success';
                $re['reason'] = '登录成功';
            }
        }
    }
}

echo json_encode($re);