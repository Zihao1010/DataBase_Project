<?php

class TableAdminForUsers
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
    //查找表users
    // 成功返回id 否则返回null
    function search($username,$password){
        if ($password !="")
            return mysqli_query($this->conn,"SELECT * FROM user WHERE Username='".$username."'AND Password='".$password."'");
        else
            return mysqli_query($this->conn,"SELECT * FROM user WHERE Username='".$username."'");
    }
    function insert($username,$password,$firstname,$lastname,$birthday,$certificate,$phone){

        $result = mysqli_query($this->conn, "SELECT Username from user where Username = '".$username."'");
        if ($result->num_rows != 0) {
            return -1;
        }
        $sql ="INSERT INTO user (Username,Password,Firstname, Lastname, Birthday, Certificate, Phone)
                VALUES ('".$username."', '".$password."', '".$firstname."', '".$lastname."', '".$birthday."', '".$certificate."', '".$phone."');";
        if (mysqli_query($this->conn, $sql)) {
                return $username;
        }
        return null;
    }
    //更新 users信息
    function update($username,$firstname,$lastname,$birthday,$certificate,$phone){
  
            mysqli_query($this->conn,"UPDATE user SET Firstname='".$firstname."',Lastname='".$lastname."',Birthday='".$birthday."',Certificate='".$certificate."',Phone='".$phone."'  WHERE Username='".$username."';");
    }

    function updatePassword($username, $newPassword){

            mysqli_query($this->conn, "UPDATE user set Password = '".$newPassword."' where Username = '".$username."'");
    }

}