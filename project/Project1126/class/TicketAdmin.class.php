<?php session_start();
require_once ("class/TableAdminForFlight.class.php");
require_once ("class/TableAdminForTicket.class.php");
require_once ("class/TableAdminForUsers.class.php");
require_once ("class/TableAdminForPassengers.class.php");

class TicketAdmin
{
    private $tableFlight;
    private $tableTicket;
    private $tableUsers;
    private $tablePassenger;
    
    //构造函数
    function __construct(){
        $this->tableFlight = new TableAdminForFlight();
        $this->tableTicket = new TableAdminForTicket();
        $this->tableUsers = new TableAdminForUsers();
        $this->tablePassenger = new TableAdminForPassengers();

    }
    // 预定票
    //参数：航班号，购票数量
    function bookingTicket($Name,$flight,$start,$terminus,$start_time,$num,$certificate,$phone){
        if (isset($_SESSION["userID"]) && $_SESSION["userID"]!=""){
            $result = $this->tableUsers->search($Name, "");

            if ($result->num_rows == 1) {
                $row = mysqli_fetch_array($result);
                $Name = $row['Firstname']." ".$row['Lastname'];

            }
        }

        $result=$this->tableFlight->search($flight,$start,$terminus,$start_time);
        if ($result->num_rows == 0){
            echo $flight;
            echo $start_time;
            echo "<script>alert('No flight found!!!');</script>";

        }
        $row = mysqli_fetch_array($result);
        $remain=$row['Remain'];  //当前座位余量

        if(!(isset($_SESSION["userID"]) && $_SESSION["userID"]!="")){

            $passeger = $this->tablePassenger->insert($Name,$row["Flight_id"],$row["Flight"],$certificate,$phone);
        }


        if($remain<$num){ // 余票不足
            echo "<script>alert('Sorry, not enough remaning tickets.');</script>";
            return;
        }
        $passenger_num=$row['Passenger_num'];  //当前乘客数
        for ($n=0;$n<$num;$n++){ //创建机票
            $this->tableTicket->insert($row["Flight_id"],$row["Flight"],$Name,$row["Start_time"],$row["End_time"],$row["Start"],$row["Terminus"],$row["Company"],$row["Price"]);

            if (isset($_SESSION["userID"]) && $_SESSION["userID"]!=""){
                $updateOderHistory = $this->tableTicket->searchMaxId();
                $row_updateOderHistory = mysqli_fetch_array($updateOderHistory);
                $this->tableTicket->insertOderHistory($row_updateOderHistory['Id'], $_SESSION["userID"],$row_updateOderHistory['Price'], date("Y-m-d H:i:s"));
            }

        }
        $this->tableFlight->update($row["Flight_id"],$passenger_num+$num,$remain-$num);
        echo "<script>alert('You have booked ".$num." flight tickets!');</script>";
    }
    //    退票
    function refundTicket($flight,$start, $terminus, $start_time,$ticket_id){
        $this->tableTicket->deleteTicket($ticket_id);
        $this->tableTicket->deleteOrder($ticket_id);

        $result= $this->tableFlight->search($flight,$start,$terminus ,$startTime);
        $row = mysqli_fetch_array($result);
        $this->tableFlight->update($row["Flight_id"],$row["Passenger_num"]-1,$row["Remain"]+1);
        echo "<script>alert('Cancellation is completed!')</script>";
    }
    // 显示所有用户预定的票
    function OrderManagement($username){

            $result = $this->tableTicket->searchOrderHistory($username);
            if($result->num_rows > 0){
                echo " <table width='100%'  align=\"center\" border='1'>";
                echo "<header><h2 align='center'>Order History</h2></header>";
                echo "<tr><td>Ticket Id</td><td>Flight</td><td>Name</td><td>Departure Time</td><td>Arrival Time</td><td>Departure Airport</td><td>Arrival Airport</td><td>Airline</td><td>Price</td><td>Order Time</td><td></td></tr>";
                while ($row = mysqli_fetch_array($result)){
                    $ticketInfo = $this->tableTicket->searchTicket($row['Ticket_id']);
                    $row_ticketInfo = mysqli_fetch_array($ticketInfo);

                    echo "<tr><td>".$row["Ticket_id"]."</td>";
                    echo "<td>".$row_ticketInfo["Flight"]."</td>";
                    echo "<td>".$row_ticketInfo["Name"]."</td>";
                    echo "<td>".$row_ticketInfo["Start_time"]."</td>";
                    echo "<td>".$row_ticketInfo["End_time"]."</td>";
                    echo "<td>".$row_ticketInfo["Start"]."</td>";
                    echo "<td>".$row_ticketInfo["Terminus"]."</td>";
                    echo "<td>".$row_ticketInfo["Company"]."</td>";
                    echo "<td>".$row_ticketInfo["Price"]."</td>";
                    echo "<td>".$row["Date"]."</td>";
                    echo "<td><a href='person.php?action=refund&&flight=".$row_ticketInfo['Flight']."&start=".$row_ticketInfo["Start"]."&terminus=".$row_ticketInfo["Terminus"]."&start_time=".$row_ticketInfo['Start_time']."&ticket_id=".$$row["Ticket_id"]."'><input type='button' class=\"btn\" value='Cancel'></a></td></tr>";
                }
                echo " </table>";
            }else{
                echo "<script>alert('No flight reservation available!')</script>";
            }
    }
}