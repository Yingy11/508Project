<html>
<head>
<title>Restaurant database (Owner)</title>
<?php require_once('header.php'); ?>
</head>

<?php require_once('connection.php'); ?>

<body>
<?php 
	
	$owner = $conn -> query("SELECT * FROM owners WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();
	if(!is_array($owner)){
		header("Location: logout.php");
	}
	
	if(!empty($_GET['message'])){
		$msg=$_GET['message'];  
		echo $msg; 
		unset($_GET['message']); 
	}
?>
<div class="container-fluid mt-3 mb-3">
    <ul>
    	<li><a href="owner_functions.php">View/Edit/Add Employee Info</a></li>
	<li><a href="owner_request_off_view.php">View/Edit All Off Work Requests</a></li>
	<li><a href="order_request_view.php">View/Edit Order Requests</a></li>
	<li><a href="order.php">View/Edit/Add Orders</a></li>
	<li><a href="logout.php">Log out</a></li>
	<li><a href="changepass.php">Change Password</a></li>
    </ul>
</div>

</body>
</html>
