<?php

require_once ("class/TableAdminForUsers.class.php");
class LoginVerification
{
    function login($username,$password,$type){
        $tableUsers=new TableAdminForUsers();
        $result=$tableUsers->search($username,"");
        $row = mysqli_fetch_array($result);   

        if ($result->num_rows==1 && $row["Password"]==$password){

            if (($type=="user" && $row["isAdmin"] == 0) || ($type=="admin" &&$row["isAdmin"] == 1)){
                return $type;
            }
            elseif($type !="user" && $type !="admin"  ){

                return "Please select one user type!";
            } 
            else{
                return "The user exist, but the type is wrong!";
            }
        
        }
        return "Your username and/or password does not match our record!";




    }
}