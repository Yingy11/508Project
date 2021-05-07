html>
<head>
<title>HR database - Employees</title>
<?php require_once('header.php'); ?>

<!-- Font Awesome library -->
<script src="https://kit.fontawesome.com/c6c713cdbc.js"></script>

<!-- JS libraries for datatables buttons-->
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<script src="js/advanced-employee.js"></script>

<!-- CSS for datatables buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"/>
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
					<th>Job_title</th>
					<th>Wage</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div id="employee-modal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="employee-form">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Emploee</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">

						
						<label>Email</label> <input type="text" class="form-control" id="email"  required>
						
						<label>Phone</label> <input type="number" class="form-control" id="phone" size="10" step="1" required>
						
						<label>Dob</label> <input type="date" class="form-control"  id="dob" required>
						
						<label>Address</label> <input type="text" class="form-control" id="address" required>

					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="ID" id="ID"/>
					<input type="hidden" name="action" id="action" value=""/>
					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

</body>
</html>
