<?php

class TableAdminForPassengers{
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
    //出入一条数据到表passengers
    //成功返回 id,否则返回null
    function  insert($name,$flight_id,$flight,$certificate,$phone)
    {

            $sql = "INSERT INTO passengers (Name,Flight_ID,Flight,Certificate,Phone)
                    VALUES ('".$name."', '".$flight_id."', '".$flight."', '".$certificate."', '".$phone."');";
            if (mysqli_query($this->conn, $sql)) {
                return mysqli_insert_id($this->conn);
            } else {
                return null;
            }
        
        return null;
    }
    /*
    //查找乘客信息by id;
    function  search($userId){
        return mysqli_query($this->conn,"SELECT * FROM passengers WHERE Id='".$userId."'");
    }
    
    function update($userId,$userName,$certificate,$phone){
        mysqli_query($this->conn,"UPDATE passengers SET Name='".$userName."',Certificate='".$certificate."',Phone='".$phone."' WHERE Id='".$userId."';");
    }*/
}