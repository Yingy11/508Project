<html>
<head>
<title>HR database (Worker)</title>
<?php require_once('header.php'); ?>
</head>

<?php require_once('connection.php'); ?>

<?php 
	
	$worker = $conn -> query("SELECT * FROM workers WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();
	if(!is_array($worker)){
		header("Location: logout.php");
	}
	
	if(!empty($_GET['message'])){
		$msg=$_GET['message'];  
		echo $msg; 
		unset($_GET['message']); 
	}
?>
<body>

<div class="container-fluid mt-3 mb-3">
    <ul>
    	<li><a href="advanced-employee.php"> View/Update Infomation</a></li>
	<li><a href="request_off.php"> View/Request Off Work</a></li>
    	<li><a href="logout.php">Logout</a></li>
    </ul>
</div>

</body>
</html>
