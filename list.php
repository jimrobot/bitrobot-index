<?php
include_once("../route/default.php");
include_once("../admin/config.php");
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("location:login.html");
    exit;
}
$pdo = new PDO("mysql:host=" . MYSQL_SERVER . ";dbname=bitrobot", MYSQL_USERNAME, MYSQL_PASSWORD);
$sql = "SELECT * FROM " . MYSQL_PREFIX . "files WHERE status=0";
$result = $pdo->query($sql);
if ($result == false ) {
    echo '服务器错误，请联系管理员';
    exit;
} else {
    $list = array();
    while($tmp = $result->fetch(PDO::FETCH_ASSOC)) {
        $list[] = $tmp;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>比特创客教育</title>
<!-- core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/animate.min.css" rel="stylesheet">
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/owl.transitions.css" rel="stylesheet">
<link href="css/prettyPhoto.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->       
</head><!--/head-->
<body>
    <header id="header">
	<nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a>
			</div>
		</div><!--/.container-->
	</nav><!--/nav-->
    </header><!--/header-->
    <div class="container">
        <div class="list-content">
            <div style="font-weight: bold; margin-bottom: 20px;">文件列表</div>
            <?php foreach ($list as $l) { ?>
            <div class="list-item clearfix"><span><?php echo $l['filename']; ?></span><a class="list-download btn btn-primary" href="<?php echo UPLOAD_URL . $l['path']; ?>" download="<?php echo $l['title']; ?>">下载</a></div>
            <?php } ?>
        </div>
    </div>
    <footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">青岛比特创客教育 &copy; 2017.鲁ICP备案************<a target="_blank" href="qingdaowanfan.com">青岛万帆文化传媒有限责任公司</a></div>
		</div>
	</div>
</footer><!--/#footer-->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>