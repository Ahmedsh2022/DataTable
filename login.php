<?php 
SESSION_START();
include 'Database.php';
$db = new Database();
if (isset($_SESSION['id']) && $_SESSION['is_login']) {
    header('Location:index.php');
}
$errorMasseage = '';
if (isset($_POST['txtUserName'])) {
    $result = $db->doLogin();
    if ($result != '') {
        $errorMasseage = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>صفحة تسجيل الدخوال :: مدير الموقع</title>
    <link rel="stylesheet" href="aa/styles/style.min.css">

    <!-- Waves Effect -->
    <link rel="stylesheet" href="aa/plugin/waves/waves.min.css">

    <!-- RTL -->
    <link rel="stylesheet" href="aa/styles/style-rtl.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Amiri:wght@700&display=swap" rel="stylesheet">
    <style>
        body,
        strong,
        * {
            /* font-family: 'Almarai', sans-serif; */
            font-family: 'Amiri', serif;
        }

        .title {
            font-family: 'Amiri', serif;
        }

        .txt-danger {
            font-family: 'Amiri', serif;
            color: red;
            text-align: center;

        }
    </style>
</head>

<body>

    <div id="single-wrapper">
        <form action="" method="post" class="frm-single">
            <div class="inside">
                <div class="title"><strong>أحمد </strong>فون</div>
                <!-- /.title -->
                <div class="frm-title">منطقة تسجيل الدخول</div>
                <div class="txt-danger">
                    <?= $errorMasseage ?>
                </div>
                <!-- /.frm-title -->
                <div class="frm-input"><input type="text" name="txtUserName" placeholder="اسم المستخدم" class="frm-inp"><i class="fa fa-user frm-ico"></i></div>
                <!-- /.frm-input -->
                <div class="frm-input"><input type="password" name="txtPassword" placeholder="كلمة المرور" class="frm-inp"><i class="fa fa-lock frm-ico"></i></div>
                <!-- /.frm-input -->

                <!-- /.clearfix -->
                <button type="submit" class="frm-submit">تسجيل الدخوال<i class="fa fa-arrow-circle-right"></i></button>

                <!-- /.row -->
                <!-- <a href="page-register.html" class="a-link"><i class="fa fa-key"></i>انشا حساب? تسجيل.</a> -->
                <div class="frm-footer">أحمد فون © <?= date('Y') ?>.</div>
                <!-- /.footer -->
            </div>
            <!-- .inside -->
        </form>
        <!-- /.frm-single -->
    </div><!--/#single-wrapper -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
		<script src="assets/script/html5shiv.min.js"></script>
		<script src="assets/script/respond.min.js"></script>
	<![endif]-->
    <!-- 
	================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/scripts/jquery.min.js"></script>
    <script src="assets/scripts/modernizr.min.js"></script>
    <script src="assets/plugin/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugin/nprogress/nprogress.js"></script>
    <script src="assets/plugin/waves/waves.min.js"></script>

    <script src="assets/scripts/main.min.js"></script>
</body>

</html>