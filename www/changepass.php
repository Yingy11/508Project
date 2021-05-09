<html>
<head>
<title>Restuarant Database - Change Password</title>
<?php require_once('header.php'); ?>
</head>

<?php require_once('connection.php'); ?>

<body>

	<div class="container mt-3 mb-3">
		<form method="post">
			<div class="row justify-content-center">
					<div class="form-group">
						<label>Password:</label>
						<input type="password" class="form-control" id="password" placeholder="Enter New password" name="password" required>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					
				</div>
			</div>
		</form>
	</div>
	

</body>
<?php 

	if (isset($_POST['password'])){
		$owner = $conn -> query("SELECT * FROM owners WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();
		$manager = $conn -> query("SELECT * FROM managers WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();
		$newpass =  password_hash($_POST['password'], PASSWORD_DEFAULT);
		$stmt = $conn->prepare("UPDATE employees SET password = '{$newpass}' WHERE employee_ID = '{$_SESSION['user_ID']}' ");
        	$stmt->execute();
		if(is_array($manager)){
			header("Location: manager.php?message=Password Changed"); 
		}
		else if(is_array($owner)){
			header("Location: owner.php?message=Password Changed");	
		}
		else {
			header("Location: worker.php?message=Password Changed");		
		}
		
	} 



?>

</html>


