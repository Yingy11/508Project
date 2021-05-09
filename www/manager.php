<html>
<head>
<title>HR database (Manager)</title>
<?php require_once('header.php'); ?>
</head>

<?php require_once('connection.php'); ?>

<body>
<?php 
	
	$manager = $conn -> query("SELECT * FROM managers WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();
	if(!is_array($manager)){
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
    	<li><a href="basic-employee.php">View Employee Info</a></li>
	<li><a href='advanced-employee.php'>View/Update Personal Info</a></li>
	<li><a href='request_off_review.php'>Review Pending Off Work Requests</a></li>
	<li><a href='request_off_view.php'>View Request Off Work Log (All Reviewed)</a></li>
	<li><a href='order_request.php'>View/Add Order Requests</a></li>
	<li><a href='order_view.php'>View Orders Log</a></li>
    	<li><a href="logout.php">Logout</a></li>
    </ul>
</div>

</body>
</html>
