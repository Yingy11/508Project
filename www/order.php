<html>
<head>
<title>Restuarant Database - Owner</title>
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

<script src="js/order.js"></script>

<!-- CSS for datatables buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"/>
</head>

<?php require_once('connection.php'); ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>Orders</h4>
	
	<div class="pb-3">
		<button type="button" id="addEmployee" class="btn btn-primary btn-sm">Add Employee</button>
	</div> 
        	
	<div class="table-responsive">
		<table id="table-employee" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID></th>
					<th>Item Name</th>
					<th>Quantity</th>
					<th>Order Date</th>
					<th>Arrival Date</th>
					<th>Cost</th>
					<th>Ordered By</th>
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

						<label>Item Name</label><input type="text" class="form-control" id="item_name" required>
						
						<label>Quanity</label> <input type="number" class="form-control"  min="1" step="1" id="quantity" required>
						
						<label>Order Date</label> <input type="date" class="form-control" id="order_date" required>
						
						<label>Arrival Date</label> <input type= "date" class="form-control" value="" id="arrival_date">
			
						<label>Cost</label> <input type="text" class="form-control" id="cost" required>
						
           

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
