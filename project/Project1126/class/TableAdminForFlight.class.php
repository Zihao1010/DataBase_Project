<?php

class TableAdminForFlight
{
    private $conn;
    //构造函数
    function __construct(){
        $xml=simplexml_load_file("config.xml");
        // 创建连接
        $this->conn =mysqli_connect($xml->serverName, $xml->userName, $xml->password, $xml->dbName);
        // 检测连接
        if (! $this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    //析构函数
    function __destruct(){
        mysqli_close($this->conn);
    }
    //根据航班号查询航班信息
    function search($flight,$start,$terminus ,$startTime){
        if ($flight!=""){
            return mysqli_query($this->conn,"SELECT * FROM flight WHERE Flight='".$flight."' and Start = '".$start."' and Terminus = '".$terminus."' and
                year(Start_time) = year('".$startTime."') and
                month(Start_time) = month('".$startTime."') and
                day(Start_time) = day('".$startTime."')");
        }else{
            return mysqli_query($this->conn,"SELECT f.flight as flight, concat(a.id,' ',a.airport) as start ,concat(b.id,' ',b.airport) as terminus, f.Start_time, f.End_time,f.remain as remain, f.price as price FROM flight f, airport a, airport b where 
                year(Start_time) = year('".$startTime."') and
                month(Start_time) = month('".$startTime."') and
                day(Start_time) = day('".$startTime."') and
                 (a.city = '".$start."' and a.id = f.Start) and (b.city = '".$terminus."' and b.id = f.Terminus)
");
        }
    }

    function searchAirportBasedOnCity($u_city){
        return mysqli_query($this->conn,"SELECT * FROM airport where city = '".$u_city."'");

    }

    function findFlight_id($flight,$startTime){

        $result = mysqli_query($this->conn,"SELECT * FROM flight WHERE Flight='".$flight."' and
                year(Start_time) = year('".$startTime."') and
                month(Start_time) = month('".$startTime."') and
                day(Start_time) = day('".$startTime."')");
        $row = mysqli_fetch_array($result);
        return $row["Flight_id"];


    }
    //售票或者退票后  ，改变乘客数量、座位余量
    function update($flight_id,$passenger_num,$remain){
        mysqli_query($this->conn,"UPDATE flight SET Remain= '".$remain."',Passenger_num='".$passenger_num."' WHERE Flight_id='".$flight_id."'");
    } 
    /*
    //获取所有目的地
    function getAllStartCity(){
        return  mysqli_query($this->conn,"SELECT distinct Start FROM flight");
    }
    //获取所有目的地
    function getAllTerminusCity(){
        return mysqli_query($this->conn,"SELECT distinct Terminus FROM flight");
    }*/
    function getAllInfo(){
        return mysqli_query($this->conn,"SELECT * FROM ticket limit 100");
    }
    //添加航班
    function insert($Flight,$Start,$Terminus,$Start_time,$End_time,$Company,$Passenger_num,$Remain,$Price){
        $sql ="INSERT INTO flight (Flight,Start,Terminus,Start_time,End_time,Company,Passenger_num,Remain,Price)
                VALUES ('".$Flight."','".$Start."','".$Terminus."','".$Start_time."','".$End_time."','".$Company."','".$Passenger_num."','".$Remain."','".$Price."');";
        if (mysqli_query($this->conn, $sql)){
            return true;
        }
        return false;
    }
    //删除航班
    function deleted($Flight,$Start_time){
       return mysqli_query($this->conn,"DELETE FROM flight WHERE Flight='".$Flight."' AND Start_time = '".$Start_time."';");
    }
    
    function updateAll($Flight_id,$Start,$Terminus,$Company,$Remain,$Price){
        $sql="UPDATE flight SET Start='".$Start."',Terminus='".$Terminus."',Remain='".$Remain."' ,Company='".$Company."',Price='".$Price."'WHERE Flight_id='".$Flight_id."';";
        return mysqli_query($this->conn,$sql);
    }
}







?>