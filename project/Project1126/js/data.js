// JavaScript Document
function login() {
	var userId=document.getElementById("userId").value;
	var password=document.getElementById("password").value;
	if(userId==""){
		alert("用户ID不能为空！")
		return false;
	}	
	if(password==""){
		alert("密码不能为空！")
		return false;
	}
	return true;
}
//验证注册
function register() {
	var username=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	var certificate=document.getElementById("certificate").value;
	var phone=document.getElementById("phone").value;
	
	if(username==""){
		alert("用户名不能为空！")
		return false;
	}	
	if(password==""){
		alert("密码不能为空！")
		return false;
	}	
	if(certificate==""){
		alert("证件号不能为空！")
		return false;
	}	
	if(phone==""){
		alert("电话号不能为空！")
		return false;
	}
	return true;
}
function modify() {
	var startCity=document.getElementById("startCity").value;
	var terminusCity=document.getElementById("terminusCity").value;
	var startTime=document.getElementById("datePicker").value;
	var myDate = new Date();
	if(startCity == ""){
		alert("请选择出发城市！");
		return false;
	}
	if(terminusCity == ""){
		alert("请选择目的城市！");
		return false;
	}
	if(startTime == ""){
		alert("请选择出发时间！");
		return false;
	}
	return true;
}

function search() {
	var flight=document.getElementById("flight").value;
	var a=document.getElementById("a_href");
	if(flight==""){
		alert("航班号不能为空！");
		return false;
	}
	a.setAttribute("href","payment.php?flight="+flight);
	return true;
}
//个人信息页，修改，是输入框可用
function change(){
	document.getElementById("userName").removeAttribute("readonly");
	document.getElementById("certificate").removeAttribute("readonly");
	document.getElementById("phone").removeAttribute("readonly");
	document.getElementById("sure").removeAttribute("disabled");
}
//个人信息页，提交修改，判断输入信息是否为空
function isEmpty(){
	var username=document.getElementById("userName").value;
	var certificate=document.getElementById("certificate").value;
	var phone=document.getElementById("phone").value;
	if(username==""){
		alert("用户名不能为空！");
		return false;
	}
	if(certificate==""){
		alert("证件号不能为空！");
		return false;
	}
	if(phone==""){
		alert("电话号不能为空！");
		return false;
	}
	return true;
}
function pwdIsEmpty(){
	var oldPwd=document.getElementById("oldPwd").value;
	var newPwd=document.getElementById("newPwd").value;
	var againPwd=document.getElementById("againPwd").value;
	if(oldPwd==""){
		alert("请输入旧密码！");
		return false;
	}
	if(newPwd==""){
		alert("请输入旧密码！");
		return false;
	}
	if(againPwd!=newPwd){
		alert("两次输入的新密码不相同！");
		return false;
	}
	return true;
}
function flightInfoIsEmpty(){
	if(document.getElementById("Flight").value ==""){
		alert("输入航班号！");
		return false;
	}	if(document.getElementById("Start").value ==""){
		alert("输入始发机场！");
		return false;
	}	if(document.getElementById("Terminus").value ==""){
		alert("输入目的机场！");
		return false;
	}	if(document.getElementById("Start_time").value ==""){
		alert("输入出发时间！");
		return false;
	}	if(document.getElementById("End_time").value ==""){
		alert("输入到达时间！");
		return false;
	}	if(document.getElementById("Company").value ==""){
		alert("输入航空公司！");
		return false;
	}	if(document.getElementById("Flight_type").value ==""){
		alert("输入飞机类型！");
		return false;
	}	if(document.getElementById("Remain").value ==""){
		alert("输入座位余量！");
		return false;
	}if(document.getElementById("Status").value ==""){
		alert("输入当前状态！");
		return false;
	}if(document.getElementById("Price").value ==""){
		alert("输入机票价格！");
		return false;
	}
	return true;
}