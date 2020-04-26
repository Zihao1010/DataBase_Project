<?php session_start();
require_once ("class/FlightAdmin.class.php");
require_once ("class/PassengerInfoAdmin.class.php");
$flightAdmin=new FlightAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Backend Management</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/data.js"></script>
</head>
<body>
<!-- header-starts -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-10 ">
                <h1 style="color: white">Online Flight Resevation Mangement</h1>
            </div>
            <div class="col-md-2">
                <?php
                if(isset($_SESSION["userID"]) && $_SESSION["userID"]!="") {
                        $ID = $_SESSION["userID"];
                        echo "<li  class=\"active\"><a href=\"person.php\">Welcome:'".$ID."'</a></li>";
                    echo "<br><a href=\"login.php\"><button class='btn'>Logout</button></a>";
                }else{
                    echo "<br><a href=\"login.php\"><button class='btn'>Login</button></a>";
                }
                ?>
            </div>
        </div>
            <!-- end h_menu4 -->
    </div>
</div>
<!-- header-ends -->
<!-- content-section-starts -->
<div class="main_bg">
    <div class="container">
        <!-- 左侧菜单-->
        <div class="row">
            <div class="col-md-2 ">
                    <ul class="s_nav">
                        <li>
                            <a href="admin.php?action=adminInfo"><input type="button" class="btn" value="Profile"  style="width: 100px;"  ></a>
                        </li>
                    </ul>
 


                    <ul class="s_nav">
                        <li>
                            <a href="admin.php?action=addFlight"><input type="button" class="btn"  style="width: 100px;" value="Add Flight"></a>
                        </li>
                    </ul>

                     <ul class="s_nav">
                        <li>
                            <a href="admin.php?action=displayDeleteFlightInterface"><input type="button" class="btn" value="Delete Flight"  style="width: 100px;"  ></a>
                        </li>
                    </ul>
                    <ul class="s_nav">
                        <li>
                            <a href="admin.php?action=flightInfo"><input type="button" class="btn" value="Flight Mangement"  style="width: 100px;"  ></a>
                        </li>
                    </ul>
                    <!--<ul class="s_nav">
                        <li>
                            <a href="admin.php?action=searchFlight"><input type="button" class="btn" value="Change Flight"  style="width: 100px;"  ></a>
                        </li>
                    </ul>   -->                
            </div>
        <!--右侧显示信息页 -->
            <div class="col-md-10  ">
<!--        <div class="row">-->
            <!--            <div class="container">-->
            <?php
            if(isset($_GET["action"])){
                if (isset($_SESSION["userID"]) && $_SESSION["userID"]!=""){
                    if($_GET["action"]=="adminInfo"){    //显示管理员的个人信息
                        (new PassengerInfoAdmin())->getUserInfo($_SESSION["userID"]);
                    }
                    
                    if($_GET["action"]=="flightInfo"){    //显示所有航班信息
                        $flightAdmin->getAllFlightInfo();
                    }
                   
                    if($_GET["action"]=="addFlight"){    //显示添加航班界面
                        $flightAdmin->displayAddFlightInterface();
                    }

                    if($_GET["action"]=="doAddFlight"&& isset($_POST["Flight"])){//添加航班
                       $flightAdmin->AddFlight($_POST["Flight"],$_POST["Start"],$_POST["Terminus"],$_POST["Start_time"],$_POST["End_time"],$_POST["Company"],$_POST["Passenger_num"],$_POST["Remain"],$_POST["Price"]);
                    }

                    if($_GET["action"]=="displayDeleteFlightInterface"){    //显示添加航班界面
                        $flightAdmin->displayDeleteFlightInterface();
                    }

                    if($_GET["action"]=="deleteFlight"&& $_POST["Flight"] && $_POST["Start_time"]){//删除航班
                        $flightAdmin->deleteFlight($_POST["Flight"], $_POST["Start_time"]);
                    }

                    if($_GET["action"]=="searchFlight" ){//显示更改航班界面
                        $flightAdmin->displaySearchFlight();
                    }

                    if($_GET["action"]=="changeFlight" && $_POST["flight"] && $_POST["Start_time"]){//显示更改航班界面
                        $flightAdmin->displayChangeFlightInterface( $_POST["flight"], $_POST["Start_time"]);
                    }

                    if($_GET["action"]=="doChangeFlight"&& isset($_POST["Flight"])) {//添加航班
                      $flightAdmin->changeFlight($_POST["Flight_id"], $_POST["Start"], $_POST["Terminus"], $_POST["Company"]
                            , $_POST["Passenger_num"], $_POST["Remain"], $_POST["Price"]);
                    }

                }else{
                    echo "<script>alert('Please Login');</script>";
                    Header('Refresh: 0; url=login.php');
                    exit();
                }
            }
            ?>
        </div>
    </div>
</div>
</div>

</body>
</html>