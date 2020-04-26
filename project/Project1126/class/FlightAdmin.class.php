<?php

require_once ('class/TableAdminForFlight.class.php');
class FlightAdmin
{
    private $tableFlight;
    //构造函数
    function __construct(){
        $this->tableFlight=new TableAdminForFlight();
    }
    /*
    //获取所有出发地
    function getAllStartCity(){
        $result = $this->tableFlight->getAllStartCity();
        while ( $row = mysqli_fetch_array($result)){
            echo "<option value='".$row["Start"]."'>".$row["Start"]."</option>";
        }
    }
    //获取所有目的地
    function getAllTerminusCity(){
        $result = $this->tableFlight->getAllTerminusCity();
        while ( $row = mysqli_fetch_array($result)){
            echo "<option value='".$row["Terminus"]."'>".$row["Terminus"]."</option>";
        }
    }*/
    //查询航班信息
    function searchFlight($flight,$start,$terminus ,$startTime){
        $result =  $this->tableFlight->search($flight,$start,$terminus,$startTime);
        if ($flight==""){
            while ( $row = mysqli_fetch_array($result)){
                echo "<tr><td>".$row["flight"]."</td>";
                echo "<td>".$row["start"]."</td>";
                echo "<td>".$row["terminus"]."</td>";
                echo "<td>".$row["Start_time"]."</td>";
                echo "<td>".$row["End_time"]."</td>";
                echo "<td>".$row["remain"]."</td>";
                echo "<td>".$row["price"]."</td>";

                echo "<td><a href='payment.php?flight=".$row["flight"]."&start=".substr($row["start"],0,3)."&terminus=".substr($row["terminus"],0,3)."&start_time=".$row["Start_time"]."'><input type='button' value='Book'></a></td></tr>";

            }
        }else{
            while ( $row = mysqli_fetch_array($result)){
                echo "".$row["Start"]." >>> To >>> ".$row["Terminus"]."<br>";
                echo ""."Flight：".$row["Flight"]."<br>";
                echo ""."Depature Time：".$row["Start_time"]."<br>";
                echo ""."Arrival Time：".$row["End_time"]."<br>";
                echo ""."Airline：".$row["Company"]."<br>";
                echo ""."Remain：".$row["Remain"]."<br>";
                echo ""."Price:".$row["Price"]."<br>";

            }

        }
    }

    function findAirpotBasedOnCity($u_city){
        return $this->tableFlight->searchAirportBasedOnCity($u_city);

    }

  
    function getAllFlightInfo(){
        $result=$this->tableFlight->getAllInfo();
        if ($result->num_rows >0){
            echo " <table class='table table-hover table-condensed'>";
            echo "<header><h2 align='center'>All Flight Info</h2></header>";
            echo "<tr><td>Flight</td><td>Start</td><td>Terminus</td><td>Start_time</td><td>End_time</td><td>Company</td><td>Price</td><td/><td/></tr>";
            while ($row = mysqli_fetch_array($result)){
                echo "<tr><td>".$row["Flight"]."</td>";
                echo "<td>".$row["Start"]."</td>";
                echo "<td>".$row["Terminus"]."</td>";
                echo "<td>".$row["Start_time"]."</td>";
                echo "<td>".$row["End_time"]."</td>";
                echo "<td>".$row["Company"]."</td>";
                echo "<td>".$row["Price"]."</td>";
               // echo "<td><a href='admin.php?action=deleteFlight&&flight=".$row["Flight"]."'><input type='button' class=\"btn\" value='delete'></a></td>";
                //echo "<td><a href='admin.php?action=changeFlight&&flight=".$row["Flight"]."'><input type='button' class=\"btn\" value='modify'></a></td></tr>";
            }
            echo "</table>";
        }

    }
    //显示添加航班界面
    function displayAddFlightInterface(){
        echo "<form action='admin.php?action=doAddFlight' method='post'>";
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        echo "<header><h2 align='center'>Add Flight</h2></header>";
        echo "<tr><td><input name='Flight' id='Flight' class=\"form-control\" placeholder='Enter Flight'></td></tr>";
        echo "<tr><td><input name='Start'id='Start' class=\"form-control\" placeholder='Enter Depature Airport'></td></tr>";
        echo "<tr><td><input name='Terminus'id='Terminus' class=\"form-control\" placeholder='Enter Arrival Airport'></td></tr>";
        echo "<tr><td><input name='Start_time'id='Start_time' class=\"form-control\" placeholder='Enter Departure Time'></td></tr>";
        echo "<tr><td><input name='End_time' id='End_time' class=\"form-control\" placeholder='Enter Arrival Time'></td></tr>";
        echo "<tr><td><input name='Company' id='Company' class=\"form-control\" placeholder='Enter Airline'></td></tr>";
        echo "<tr><td><input name='Passenger_num' id='Passenger_num' class=\"form-control\" placeholder='Enter Passenger_num'></td></tr>";
        echo "<tr><td><input name='Remain' id='Remain' class=\"form-control\" placeholder='Enter Seat Remaining'></td></tr>";
        echo "<tr><td><input name='Price' id='Price' class=\"form-control\" placeholder='Enter Price'></td></tr>";
        echo  "<td><input type='submit'class='btn'value='Confirm' onclick='return flightInfoIsEmpty();'></td></tr>";
        echo " </table></form>";
    }
    //添加航班
    function AddFlight($Flight,$Start,$Terminus,$Start_time,$End_time,$Company,$Passenger_num,$Remain,$Price){
       $result= $this->tableFlight->search($Flight,"",'','');
        if($result->num_rows >0){
            echo "<script>alert('Fail to Add！Flight：".$Flight." already exist for the specific date！');</script>";
        }else{ //插入数据到表
            //$Start_time = dateformat($Start_time);
          //  $End_time = dateformat($End_time);
            
            $result= $this->tableFlight->insert($Flight,$Start,$Terminus,$Start_time,$End_time,$Company,$Passenger_num,$Remain,$Price);
            if($result==true){
                echo "<script>alert('Success!');</script>";
            } else{
                echo "<script>alert('Failed!');</script>";
            }
        }
        header('Refresh: 0; url=admin.php?action=addFlight');
        exit();
    }

    function dateformat($time){
        $phpdate = strtotime( $time );
        $time = date( 'Y-m-d H:i:s', $phpdate );
        return $time;

    }
    //显示删除航班界面
    function displayDeleteFlightInterface(){
        echo "<form action='admin.php?action=deleteFlight' method='post'>";
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        echo "<header><h2 align='center'>Delete Flight</h2></header>";
        echo "<tr><td><input name='Flight' id='Flight' class=\"form-control\" placeholder='Enter Flight'></td></tr>";
        echo "<tr><td><input name='Start_time'id='Start_time' class=\"form-control\" placeholder='Enter Start_time'></td></tr>";
        
        echo  "<td><input type='submit'class='btn'value='Confirm' onclick='return flightInfoIsEmpty();'></td></tr>";
        echo " </table></form>";
    }
    //删除航班
    function deleteFlight($Flight, $Start_time){
        //$Start_time = dateformat($Start_time);
        $result= $this->tableFlight->deleted($Flight,$Start_time);
        if($result== true){
            echo "<script>alert('Delete Flight:".$Flight." successfully!');</script>";
        }
        if($result== false){
            echo "<script>alert('Fail to delete flight:".$Flight."');</script>";
        }
        header('Refresh: 0; url=admin.php?action=flightInfo');
        exit();
    }

    function displaySearchFlight(){

        echo "<form action='admin.php?action=changeFlight' method='post'>";
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        echo "<header><h2 align='center'>Delete Flight</h2></header>";
        echo "<tr><td><input name='Flight' id='Flight' class=\"form-control\" placeholder='Enter Flight'></td></tr>";
        echo "<tr><td><input name='Start_time'id='Start_time' class=\"form-control\" placeholder='Enter Departure Time'></td></tr>";
        
        echo  "<td><input type='submit'class='btn'value='Confirm' onclick='return flightInfoIsEmpty();'></td></tr>";
        echo " </table></form>";       
    }

    function displayChangeFlightInterface($Flight, $Start_time){
        $result =  $this->tableFlight->search($Flight,'','' ,$Start_time);
        if($result->num_rows ==1){
            $row = mysqli_fetch_array($result);
            echo "<form action='admin.php?action=doChangeFlight' method='post'>";
            echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
            echo "<header><h2 align='center'>Edit Flight Infomation</h2></header>";
            echo "<tr><td>Flight Id:</td><td><input name='Flight_id'class='form-control'readonly value='".$row["Flight_id"]."' ></td></tr>";
            echo "<tr><td>Flight:</td><td><input name='Flight'class='form-control'readonly value='".$row["Flight"]."' ></td></tr>";
            echo "<tr><td>Departure Airport:</td><td><input name='Start'id='Start' class='form-control' value='".$row["Start"]."' ></td></tr>";
            echo "<tr><td>Arrival Airport:</td><td><input name='Terminus'id='Terminus' class='form-control' value='".$row["Terminus"]."' ></td></tr>";
            echo "<tr><td>Departure Time:</td><td><input name='Start_time'id='Start_time' class='form-control'readonly value='".$row["Start_time"]."' ></td></tr>";
            echo "<tr><td>Arrival Time:</td><td><input name='End_time' id='End_time' class='form-control'readonly value='".$row["End_time"]."' ></td></tr>";
            echo "<tr><td>Airline:</td><td><input name='Company' id='Company' class='form-control' value='".$row["Company"]."' ></td></tr>";
            echo "<tr><td>Number of Pessenger:</td><td><input name='Passenger_num'  class='form-control'  value='".$row["Passenger_num"]."' ></td></tr>";
            echo "<tr><td>Seat Remaining:</td><td><input name='Remain' class='form-control'  value='".$row["Remain"]."' ></td></tr>";
            echo "<tr><td>Price:</td><td><input name='Price' id='Price' class='form-control' value='".$row["Price"]."' ></td></tr>";
            echo  "<td><input type='submit'class='btn'value='Confirm' onclick='return flightInfoIsEmpty();'></td></tr>";
            echo " </table></form>";
        }
    }
    function changeFlight($Flight_id,$Start,$Terminus,$Company,$Remain,$Price){
        $result =  $this->tableFlight->updateAll($Flight_id,$Start,$Terminus,$Company,$Remain,$Price);
        if($result== true){
            echo "<script>alert('Edit Flight id:".$Flight_id."successfully!');</script>";
        }
        if($result== false){
            echo "<script>alert('Fail to edit flight id:".$Flight_id."');</script>";
        }
        header('Refresh: 0; url=admin.php?action=flightInfo');
        exit();
    }
}