<?php session_start(); 
require_once ("class/TicketAdmin.class.php");
require_once ("class/TableAdminForUsers.class.php");

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Payment</title>
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
                if (isset($_GET['flight'])&&isset($_GET['start'])&&isset($_GET['terminus'])&&isset($_GET['start_time'])){
                    echo "<form method='post' action='payment.php?flight=".$_GET['flight']."&start=".$_GET["start"]."&terminus=".$_GET["terminus"]."&start_time=".$_GET['start_time']."'>";
                    echo "<label for='ticketNum' >Number of Tickets</label>";
                    echo "<select id='ticketNum' name='ticketNum'>";
                    for ($n=1;$n<10;$n++){
                        echo "<option value='".$n."'>".$n."</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' class='btn' value='Submit'>";
                    echo "</form>";
                }

				$ticketAdmin=new TicketAdmin();
				if (isset($_POST["ticketNum"]) &&isset($_GET['flight'])&&isset($_GET['start'])&&isset($_GET['terminus']) &&isset($_GET["start_time"])){
				    if (isset($_SESSION["userID"]) && $_SESSION["userID"]!=""){

				            $ticketAdmin->bookingTicket($_SESSION["userID"],$_GET['flight'],$_GET['start'],$_GET['terminus'],$_GET["start_time"],$_POST["ticketNum"],'','');
				    }
				    else{
				            echo "You have not logged in yet, you can either Login/Register using the bottom on the top right, or ";
				            echo "<a href='./guest.php?flight=".$_GET['flight']."&start=".$_GET["start"]."&terminus=".$_GET["terminus"]."&start_time=".$_GET['start_time']."&ticketNum=".$_POST["ticketNum"]."' style='color: #cc0000'>check out as guest.</a>";
				        }
				    
				}

                if (isset($_SESSION["userID"]) && $_SESSION["userID"]!=""){

                    $result=(new TableAdminForUsers())->search($_SESSION["userID"],'');
                     $row = mysqli_fetch_array($result);
                }
                ?>

                    <br/><br/><br/><br/>

                    <table class="row">

                        <tr><td><input readonly class="form-control" type="text" id="name" name="name" value="<?php echo $row['Firstname'].' '.$row['Lastname']?>"></td></tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr><td><input readonly class="form-control" type="text" id="certificate" name="certificate" value="<?php echo $row['Certificate']?>"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td><input readonly class="form-control" type="text" id="phone" name="phone" value="<?php echo $row['Phone']?>"></td></tr>
                        <tr><td>&nbsp;</td></tr>
                    </table>
            </div>
        </div>

    </div>
    <!-- content-section-ends -->

</body>
</html>