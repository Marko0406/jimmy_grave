<?php
session_start();
include __DIR__ . "/../../../db.php";
$email 		= $_POST['email'];
$password 	= $_POST['password'];


$sql="SELECT * FROM user WHERE email='$email'";
$result = $conn->query($sql);
if($result->num_rows != 0)
{
	$row = $result -> fetch_assoc();
	$verify = password_verify($password, $row['password']); 
	if($verify)
	{
		$return['status']=200;
		$return['token']=$row['token'];
		$return['user_name']=$row['fullname'];
		$return['user_id']=$row['id'];
		$return['email']=$row['email'];

		$_SESSION['login_flag']="1";
		$_SESSION['token']=$row['token'];
		$_SESSION['user_name']=$row['fullname'];
		$_SESSION['user_id']=$row['id'];
		$_SESSION['email']=$row['email'];

	}
	else{
		$return['status']=400;
		$return['message']='Incorrect email or password';
	}
	
}	 
else{
	$return['status']=400;
	$return['message']='Incorrect email or password';
}
echo json_encode($return);
?>