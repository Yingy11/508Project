<html>
<head>
<title>HR database - Employees</title>
<?php require_once('header.php'); ?>
<!-- My JS libraries -->
<script src="js/request_off_view.js"></script>
</head>

<?php require_once('connection.php'); ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>Employees</h4>
	<div class="table-responsive">
		<table id="table-employee" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Request Date</th>
					<th>Reason</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Status</th>
					<th>Reviewed By</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

</body>
</html>
