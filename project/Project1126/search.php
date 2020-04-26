<?php session_start();
require_once ("class/FlightAdmin.class.php");
$flightAdmin=new FlightAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Flight Reservation</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/tcal.css" />
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="js/tcal.js"></script>
    <script type="text/javascript" src="js/data.js"></script>
</head>
<body>
<!-- header-starts -->
<div class="page-header">
    <div class="container">
        <div class="page-header-info">
            <div class="h_menu4">
                <a class="toggleMenu" href="">Menu</a>
                <ul class="nav p-nav">
                    <li class="active"><a href="index.php">Homepage</a></li>
                    <li  class="active"><a href="person.php">Account</a></li>
                   <!-- <li  class="active"><a href="payment.php">Book</a></li> -->
                   <!-- <li  class="active"><a href="search.php">Search</a></li> -->
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <?php
                    if(isset($_SESSION["userID"]) && $_SESSION["userID"]!="") {
                        $ID = $_SESSION["userID"];
                        echo "<li  class=\"active\"><a href=\"person.php\">Welcome:'".$ID."'</a></li>";
                        echo "<li  class=\"active\"><a href=\"login.php\">Logout</a></li>";
                    }else{
                        echo "<li  class=\"active\"><a href=\"login.php\">Login</a></li>";
                        echo "<li  class=\"active\"><a href=\"register.php\">Register</a></li>";
                    }
                    ?>
                </ul>
                <script type="text/javascript" src="js/nav.js"></script>
            </div>
            <!-- end h_menu4 -->
        </div>
    </div>
</div>
<!-- header-ends -->
<!-- content-section-starts -->
<div class="content-section">
    <div class="container">
        <h3 class="page-title">Searching Flight</h3>
        <form method="post" action="search.php">
            <div class="reservation">
                <ul>
                    <li class="span1_of_1">
                        <h5>Departure City</h5>
                        <!----------start section_room----------->
                        <div class="section_room">
                            Departure City: <input type = 'text', id="startCity" name="startCity" class="frm-field required" >                           
                        </div>
                    </li>
                    <li class="span1_of_1">
                        <h5>Arrival City</h5>
                        <!----------start section_room----------->
                        <div class="section_room">
                            Arrival City: <input type = 'text' id="terminusCity" name="terminusCity" class="frm-field required">
                        </div>
                    </li>

                    <li  class="span1_of_1 left">
                        <h6>Departure Time</h6>
                        <div class="book_date">
                            <input class="tcal" id="datePicker" name="startTime"  type="text">
                        </div>
                    </li>
                    <li >
                        <h5>&nbsp;</h5>
                        <div>
                            <input id = 'search_city' type="submit" class="btn" value="Submit1">
                        </div>
                    </li>


                </ul>
            </div>
        </form>





    </div>
</div>
<div>
    <table class="table table-bordered">
        <caption><h3>Result</h3></caption>
        <tr>
            <th>Flight</th>
            <th>Departure Airport</th>
            <th>Arrival Airport</th>
            <th>Departure Time</th>
            <th>Arrival Time</th>
            <th>Seat Remaining</th>
            <th>Price</th>

            <th></th>
        </tr>
        <?php
        //显示查询结果
        if(isset($_POST["startCity"]) &&isset($_POST["terminusCity"]) &&isset($_POST["startTime"]))  
                                                   
            $flightAdmin->searchFlight("",$_POST["startCity"],$_POST["terminusCity"] ,$_POST["startTime"]);
        ?>
    </table>
</div>
<!-- content-section-ends -->
<!-- footer-section-starts -->
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<!-- footer-section-ends -->

</body>
</html>