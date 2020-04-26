<?php
/**
 * Created by PhpStorm.
 * User: hanhao
 * Date: 2016/5/20
 * Time: 18:45
 */
class DBAdmin
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
    //用户登录验证
    function login($userId,$password){
        $result = mysqli_query($this->conn,"SELECT * FROM users WHERE Id='".$userId."'");
       if ($result->num_rows==1){
           $row = mysqli_fetch_array($result);
            if ($row["Password"]==$password)
                return "yes";
            else
                return "The password is wrong !";
        }
        return "The user doesn't exist !";
    }
    //用户注册
    function register($username,$password,$certificate,$phone){
        $result = mysqli_query($this->conn,"SELECT * FROM passengers WHERE Certificate='".$certificate."'");
        if ($result->num_rows>0) { //用户存在
                return "The user has exist !";
        }else{
            $sql = "INSERT INTO passengers (Name,Certificate,Phone)
VALUES ('".$username."', '".$certificate."', '".$phone."');";
            $sql .="INSERT INTO users (UserName,Password)
VALUES ('".$username."', '".$password."');";
            if (mysqli_multi_query($this->conn, $sql)) {
                $newID = mysqli_insert_id($this->conn);
                echo  "<script>alert('注册成功!您的登录ID为：".$newID."')</script>";
            } else {
                return mysqli_error($this->conn);
            }
        }
    }

    //获取所有出发地
    function getAllStartCity(){
        $result = mysqli_query($this->conn,"SELECT Start FROM flight");
        while ( $row = mysqli_fetch_array($result)){
            echo "<option value='".$row["Start"]."'>".$row["Start"]."</option>";
        }
    }
    //获取所有目的地
    function getAllTerminusCity(){
        $result = mysqli_query($this->conn,"SELECT Terminus FROM flight");
        while ( $row = mysqli_fetch_array($result)){
            echo "<option value='".$row["Terminus"]."'>".$row["Terminus"]."</option>";
        }
    }
    //根据城市查找航班信息
    function searchFlightByCity($start,$terminus ,$startTime){
        $result = mysqli_query($this->conn,"SELECT * FROM flight WHERE Start='".$start."' AND Terminus='".$terminus."' AND Start_time > '".$startTime."'");
        while ( $row = mysqli_fetch_array($result)){
            echo "<tr><td>".$row["Flight"]."</td>";
            echo "<td>".$row["Start"]."</td>";
            echo "<td>".$row["Terminus"]."</td>";
            echo "<td>".$row["Start_time"]."</td>";
            echo "<td>".$row["End_time"]."</td>";
            echo "<td>".$row["Remain"]."</td>";
            echo "<td><a href='payment.php?flight=".$row["Flight"]."'><input type='button' value='预定'></a></td></tr>";
        }
    }
    //根据航班号查找航班信息
    function getFlightInfo($flight){
        $result = mysqli_query($this->conn,"SELECT * FROM flight WHERE Flight='".$flight."'");
        while ( $row = mysqli_fetch_array($result)){
           echo "<li><h1>".$row["Start"].">>>>>".$row["Terminus"]."</h1></li>";
           echo "<li>"."航 班 号：".$row["Flight"]."</li>";
           echo "<li>"."出发时间：".$row["Start_time"]."</li>";
           echo "<li>"."到达时间：".$row["End_time"]."</li>";
           echo "<li>"."航空公司：".$row["Company"]."</li>";
           echo "<li>"."座位余量：".$row["Remain"]."</li>";

        }
    }
    //获取个人信息
    function  getPassengerInfo($userId){
        $result = mysqli_query($this->conn,"SELECT * FROM passengers WHERE Id='".$userId."'");
        $row = mysqli_fetch_array($result);
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        echo "<header><h1 align='center'>个人信息</h1></header>";
        echo "<tr><td>用户ID：</td><td>".$row["Id"]."</td></tr>";
        echo "<tr><td>用户名：</td><td>".$row["Name"]."</td></tr>";
        echo "<tr><td>证件号：</td><td>".$row["Certificate"]."</td></tr>";
        echo "<tr><td>电话号：</td><td>".$row["Phone"]."</td></tr>";
        echo " </table>";
    }
//    订单管理
    function OrderManagement($userId){
        $result = mysqli_query($this->conn,"SELECT * FROM users WHERE Id='".$userId."'");
        if($result->num_rows > 0){
            $row = mysqli_fetch_array($result);
            $result = mysqli_query($this->conn,"SELECT * FROM ticket WHERE Name='".$row["UserName"]."'");
            if($result->num_rows > 0){
                echo " <table width='850px'  align=\"center\" border='1'>";
                echo "<header><h2 align='center'>订票信息</h2></header>";
                echo "<tr><td>航班号</td><td>乘客姓名</td><td>出发时间</td><td>到达时间</td><td>始发机场</td><td>目的机场</td><td>航空公司</td><td>机票价格</td><td>座位号</td><td></td></tr>";
                while ($row = mysqli_fetch_array($result)){
                    echo "<tr><td>".$row["Flight"]."</td>";
                    echo "<td>".$row["Name"]."</td>";
                    echo "<td>".$row["Start_time"]."</td>";
                    echo "<td>".$row["End_time"]."</td>";
                    echo "<td>".$row["Start"]."</td>";
                    echo "<td>".$row["Terminus"]."</td>";
                    echo "<td>".$row["Company"]."</td>";
                    echo "<td>".$row["Price"]."</td>";
                    echo "<td>".$row["Sit"]."</td>";
                    echo "<td><a href='person.php?action=refund&&flight=".$row["Flight"]."&&sit=".$row["Sit"]."'><input type='button' class=\"btn\" value='退票'></a></td></tr>";
                }
                echo " </table>";
            }else{
                echo "<script>alert('暂时还没有订票信息!')</script>";
            }
        }
    }
//    退票
    function refundTicket($userId,$flight,$sit){
        $result = mysqli_query($this->conn,"SELECT * FROM users WHERE Id='".$userId."'");
        if($result->num_rows > 0){
            $row = mysqli_fetch_array($result);
            mysqli_query($this->conn,"DELETE FROM ticket WHERE Name='".$row["UserName"]."'AND Sit='".$sit."'");

            $result = mysqli_query($this->conn,"SELECT * FROM flight WHERE Flight='".$flight."'");
            if($result->num_rows > 0) {  //查到该航班
                $row = mysqli_fetch_array($result);
                mysqli_query($this->conn, "UPDATE flight SET Remain= '" . ($row["Remain"] + 1) . "',Passenger_num='" . ($row["Passenger_num"] - 1) . "' WHERE Flight='" . $flight . "'");
            }
            echo "<script>alert('退票成功!')</script>";
        }
    }
    // 预定票
    //参数：航班号，购票数量
    function BookingTicket($userId,$flight,$num){
        $result = mysqli_query($this->conn,"SELECT * FROM users WHERE Id='".$userId."'");
        if($result->num_rows > 0){//用户存在
            $row = mysqli_fetch_array($result);
            $userName=$row["UserName"];
            $result = mysqli_query($this->conn,"SELECT * FROM flight WHERE Flight='".$flight."'");
            if($result->num_rows > 0){  //查到该航班
                $row = mysqli_fetch_array($result);
                if ($row["Remain"]>$num){  //余票充足
                    $sql="";
                    for($n=0;$n<$num;$n++){
                        $sql ="INSERT INTO ticket (Flight,Name,Start_time,End_time,Start,Terminus,Company,Price,Sit)
VALUES ('".$row["Flight"]."', '".$userName."', '".$row["Start_time"]."', '".$row["End_time"]."', '".$row["Start"]."', '".$row["Terminus"]."', '".$row["Company"]."', '".$row["Price"]."', '".($row["Remain"]-$n)."');";
                        if (mysqli_query($this->conn,$sql)) {
                            mysqli_query($this->conn,"UPDATE flight SET Remain= '".($row["Remain"]-$num)."',Passenger_num='".($row["Passenger_num"]+$num)."' WHERE Flight='".$flight."'");
                        } else {
                            echo "<script>alert('".mysqli_error($this->conn)."');</script>";
                            return;
                        }
                    }
                    echo "<script>alert('购票成功！".$num."张');</script>";
                }else{ //余票不足
                    echo "<script>alert('购票失败，余票不足！');</script>";
                }
            }
        }
    }
}