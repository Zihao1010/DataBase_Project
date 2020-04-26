<?php
     if(isset($_POST["birthday"])){
        $birthday = $_POST["birthday"];
        $phpdate = strtotime( $birthday );
        $birthday = date( 'Y-m-d H:i:s', $phpdate );
     }
    if(isset($_POST["username"])&&isset($_POST["password"])&&isset($_POST["firstname"])&&isset($_POST["lastname"])&&isset($_POST["birthday"])&&isset($_POST["certificate"])&&isset($_POST["phone"])){
        require_once ("class/PassengerInfoAdmin.class.php");
        $db=new PassengerInfoAdmin();
        $db->register($_POST["username"],$_POST["password"],$_POST["firstname"],$_POST["lastname"],$birthday,$_POST["certificate"],$_POST["phone"]);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>register</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script src="js/data.js"></script>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<!-- header-starts -->
<div class="header">
    <div class="container">
        <div class="header-info">
            <div class="header-info-head text-center">
                <form method="post" action="register.php">
                    <table class="row">
                        <tr><td><input class="form-control" type="text" id="username" name="username" placeholder="Username"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="password"  id="password" name="password" placeholder="Password"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="text" id="firstname" name="firstname" placeholder="Firstname"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="text" id="lastname" name="lastname" placeholder="Lastname"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="date" id="birthday" name="birthday" placeholder="Birthday"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="text" id="certificate" name="certificate" placeholder="Certificate"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="text" id="phone" name="phone" placeholder="Phone"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input name="button" type="submit" class="btn" onClick=" return register();" value="register"> <a href="index.php" class="btn">Homepage</a></td></tr>
                    </table>
                </form>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            </div>

        </div>
    </div>
</div>
<!-- header-ends -->
<!-- footer-section-starts -->

<!-- footer-section-ends -->
</body>
</html>