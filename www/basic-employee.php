<html>
<head>
<title>HR database - Employees</title>
<?php require_once('header.php'); ?>
<!-- My JS libraries -->
<script src="js/basic-employee.js"></script>
</head>

<?php require_once('connection.php'); ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>Employees</h4>
	<div class="table-responsive">
		<table id="table-employee" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Dob</th>
					<th>Address</th>
					<th>Job Title</th>
					<th>Wage</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

</body>
</html>
