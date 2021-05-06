<html>
<head>
<title>HR database - Owner</title>
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

<script src="js/owner_functions.js"></script>

<!-- CSS for datatables buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"/>
</head>

<?php require_once('connection.php'); ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>Employees</h4>
	
	<div class="pb-3">
		<button type="button" id="addEmployee" class="btn btn-primary btn-sm">Add Employee</button>
	</div> 
        	
	<div class="table-responsive">
		<table id="table-employee" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID></th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Dob</th>
					<th>Address</th>
					<th>Job Title</th>
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

						<label>Name</label><input type="text" class="form-control" id="name" placeholder="Enter name" required>
						
						<label>Email</label> <input type="text" class="form-control" id="email" placeholder="Enter email" required>
						
						<label>Phone</label> <input type="number" class="form-control" id="phone" placeholder="Enter phone" required>
						
						<label>Dob</label> <input type= "date" class="form-control" id="dob" value="2021-05-01" required>
			
						<label>Address</label> <input type="text" class="form-control" id="address" placeholder="Enter address" required>
						
						<label>Wage</label> <input type="number" class="form-control" min="0.01" step="0.01" size="8" value="0" id="wage">
						
						<label>Job Title</label>
						<select class="form-control" id="job_title">
            			    <?php
            			        $sqlQuery = "SELECT DISTINCT job_title FROM employees ORDER BY job_title ASC";
            			        $stmt = $conn->prepare($sqlQuery);
            			        $stmt->execute();
            			        while ($row = $stmt->fetch()) {
            			            echo '<option>' .$row['job_title'].  '</option>';
            			        }
                            ?>
            			</select>
           

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
