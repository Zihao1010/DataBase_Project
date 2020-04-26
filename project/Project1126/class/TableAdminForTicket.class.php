<?php

class TableAdminForTicket
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
    //添加机票
    function insert($Flight_ID,$Flight,$Name,$Start_time,$End_time,$Start,$Terminus,$Company,$Price){
        $sql ="INSERT INTO ticket (Flight_ID,Flight,Name,Start_time,End_time,Start,Terminus,Company,Price)
                VALUES ('".$Flight_ID."','".$Flight."', '".$Name."', '".$Start_time."', '".$End_time."', '".$Start."', '".$Terminus."', '".$Company."', '".$Price."');";
        mysqli_query($this->conn,$sql);
    }

    function insertOderHistory($Ticket_id, $Username,$Payment, $Date){
        $sql = "INSERT INTO order_history(Ticket_id,Username,Payment, Date)
                VALUES ('".$Ticket_id."', '".$Username."', '".$Payment."', '".$Date."');";
        mysqli_query($this->conn,$sql);
    }
    
    //删除机票
    function  delete($flight,$sit){
        mysqli_query($this->conn,"DELETE FROM ticket WHERE Flight='".$flight."'AND Sit='".$sit."'");
    }
    //查询
    function searchOrderHistory ($username){
        return  mysqli_query($this->conn,"SELECT * FROM order_history WHERE Username='".$username."'");
    }

    function searchTicket($ticket_id){
        return  mysqli_query($this->conn,"SELECT * FROM ticket WHERE id='".$ticket_id."'");
    }

    function searchMaxId(){
        return  mysqli_query($this->conn,"SELECT * FROM ticket WHERE Id=(select max(id) from ticket); ");
    }
}