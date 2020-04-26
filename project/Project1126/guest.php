<?php session_start(); 
require_once ("class/TicketAdmin.class.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Guest Check Out</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
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
                    <li class="active"><a href="index.php">Home</a></li>
                    <li  class="active"><a href="person.php">Account</a>
                   <!-- <li  class="active"><a href="payment.php">Book</a></li> -->
                   <!-- <li  class="active"><a href="search.php">Search</a></li> -->
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <?php
                    if(isset($_SESSION["userID"]) && $_SESSION["userID"]!="") {
                        $ID = substr($_SESSION["userID"]);
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
    <div class="container">
        <div class="paymemt-row-wrap">
            <div class="col-md-6">
                <div class="booking-item-payment">
                    <ul class="booking-item-payment-details" style="font-size: 20px">
                        <?php

                        if(isset($_GET["flight"])){

                            require_once ("class/FlightAdmin.class.php");
                            (new FlightAdmin())->searchFlight($_GET["flight"],$_GET["start"],$_GET["terminus"],$_GET["start_time"]);
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 ">
               <!-- <input id="flight" placeholder="Flight Number">&nbsp;<a id="a_href"><input type="button" onclick="return search();" class="btn" value="Search"></a> -->
<br/><br/><br/><br/>

                <?php
                //显示预定表单
                if (isset($_GET['flight'])){
                    echo "<label for='ticketNum' >Number of Tickets</label>";
                    echo "<select id='ticketNum' name='ticketNum'>";

                    echo "<option value='".$_GET["ticketNum"]."'>".$_GET["ticketNum"]."</option>";

                    echo "</select>";
                    echo "</form>";
                }
                ?>
            </div>

            <div>
                <br/><br/><br/><br/>

                <form method="post" action="guest.php?flight=<?php echo $_GET['flight'];?>&start=<?php echo $_GET["start"];?>&terminus=<?php echo $_GET["terminus"];?> &start_time=<?php echo $_GET['start_time'];?> &ticketNum= <?php echo $_GET["ticketNum"];?>">
                    <table class="row">

                        <tr><td><input class="form-control" type="text" id="name" name="name" placeholder="Name"></td></tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr><td><input class="form-control" type="text" id="certificate" name="certificate" placeholder="Certificate"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input class="form-control" type="text" id="phone" name="phone" placeholder="Phone"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input type='submit' class='btn' value='Submit'></a></td></tr>
                    </table>
                </form>

                <?php
				$ticketAdmin = new TicketAdmin();
				if (isset($_GET["ticketNum"]) &&isset($_GET['flight']) &&isset($_GET["start_time"])&&isset($_POST['name'])&&isset($_POST['certificate'])&&isset($_POST['phone'])){                
       			
						$ticketAdmin->bookingTicket($_POST['name'],$_GET['flight'],$_GET['start'],$_GET['terminus'],$_GET["start_time"],$_GET["ticketNum"],$_POST['certificate'],$_POST['phone']);
				}
                    ?>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            </div>
        </div>

    </div>
    <!-- content-section-ends -->

</body>
</html>