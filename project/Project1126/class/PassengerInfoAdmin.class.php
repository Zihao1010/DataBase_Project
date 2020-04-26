<?php

require_once ("class/TableAdminForUsers.class.php");
class PassengerInfoAdmin
{
    //用户注册
    function register($username,$password,$firstname,$lastname,$birthday,$certificate,$phone){

        $result=(new TableAdminForUsers())->insert($username,$password,$firstname,$lastname,$birthday,$certificate,$phone);
        if($result == -1){
            echo  "<script>alert('Username exists, Please try another one')</script>";
            return;
        }
        if($result!=null){
            echo  "<script>alert('Register successfully, your username is：".$result."')</script>";
            header('Refresh:0; url=login.php');
            return;
        }
        
        echo  "<script>alert('Register failed！')</script>";
    }
    /*
    //获取管理员信息
    function  getAdminInfo($username){
        $result=(new TableAdminForPassengers())->search($username);
        $row = mysqli_fetch_array($result);
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        echo "<header><h1 align='center'>Admit Infomation</h1></header>";
        echo "<tr><td>用户ID：</td><td>".$row["Id"]."</td></tr>";
        echo "<tr><td>用户名：</td><td>".$row["Name"]."</td></tr>";
        echo "<tr><td>证件号：</td><td>".$row["Certificate"]."</td></tr>";
        echo "<tr><td>电话号：</td><td>".$row["Phone"]."</td></tr>";
        echo " </table>";
    }
    */
    //获取用户信息
    function  getUserInfo($username){
        $result=(new TableAdminForUsers())->search($username,'');
        $row = mysqli_fetch_array($result);
        echo "<form action='person.php?action=updateInfo' method='post'>";
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        if ($row["isAdmin"] == 1){
            echo "<header><h1 align='center'>Admin Profile</h1></header>";
        }
        else{
            echo "<header><h1 align='center'>User Profile</h1></header>";
        }
        echo "<tr><td>Username：</td><td><input readonly name='userName' id='userName' value='".$row["Username"]."'></td></tr>";
        echo "<tr><td>Firstname：</td><td><input name='firstname' id='firstname' value='".$row["Firstname"]."'></td></tr>";
        echo "<tr><td>Lastname：</td><td><input name='lastname' id='lastname' value='".$row["Lastname"]."'></td></tr>";
        echo "<tr><td>Birthday:</td><td><input name='birthday' id='birthday' value='".$row["Birthday"]."'></td></tr>";
        echo "<tr><td>Certificate:</td><td><input  name='certificate' id='certificate' value='".$row["Certificate"]."'></td></tr>";
        echo "<tr><td>Phone:</td><td><input name='phone' id='phone' value='".$row["Phone"]."'></td></tr>";
        echo  "<td><input type='submit'class='btn' id='sure' value='Confirm' onclick='return isEmpty();'></td></tr>";
        echo " </table></form>";
    }
    //更新用户信息
    function  updateUserInfo($username,$firstname,$lastname,$birthday,$certificate,$phone){
        (new TableAdminForUsers())->update($username,$firstname,$lastname,$birthday,$certificate,$phone);
    }
    function displayChangePwdInterface(){
        echo "<form action='person.php?action=doChangePwd' method='post'>";
        echo " <table width='auto'  align=\"center\" style='font-size: 30px'>";
        echo "<header><h1 align='center'>Change Password</h1></header>";
        echo "<tr><td><input type='password' name='oldPwd'id='oldPwd' class=\"form-control\" placeholder='Old Password'></td></tr>";
        echo "<tr><td><input  type='password' name='newPwd' id='newPwd' class=\"form-control\" placeholder='New Password'></td></tr>";
        echo "<tr><td><input type='password' id='againPwd'class=\"form-control\" placeholder='Re-enter New Password'></td></tr>";
        echo  "<td><input type='submit'class='btn'value='Confirm' onclick='return pwdIsEmpty();'></td></tr>";
        echo " </table></form>";
    }
    //更改密码
    function changePassword($username,$oldPassword,$newPassword){
        $userAdmin=new TableAdminForUsers();
        $result=$userAdmin->search($username,$oldPassword);
        if ($result->num_rows == 1){
            $userAdmin->updatePassword($username,$newPassword);
            echo "<script>alert('Password change successfully, please login again')</script>";
            header('Refresh:0; url=login.php');
            exit();
        }else{
            echo "<script>alert('The old password is wrong, please try again')</script>";
            header('Refresh:0; url=person.php?action=changePwd');
            exit();
        }
    }
}