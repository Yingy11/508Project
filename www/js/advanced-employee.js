$(document).ready(function(){
	
	var tableEmployee = $('#table-employee').DataTable({
		"dom": 'Blfrtip',
		"autoWidth": false,
		"processing":true,
		"serverSide":true,
		"pageLength":15,
		"lengthMenu":[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]],
		"processing": true,
		"language": {processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'},
		"order":[],
		"ajax":{
			url:"advanced-employee-action.php",
			type:"POST",
			data:{
					action:'listEmployees'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ],
		"buttons": [
				{
					extend: 'excelHtml5',
					title: 'Employees',
					filename: 'Employees',
					exportOptions: {columns: [1,2,3,4,5,6,7]}
				},
				{
					extend: 'pdfHtml5',
					title: 'Employees',
					filename: 'Employees',
					exportOptions: {columns: [1,2,3,4,5,6,7]}
				},
				{
					extend: 'print',
					title: 'Employees',
					filename: 'Employees',
					exportOptions: {columns: [1,2,3,4,5,6,7]}
				}]
	});	
	
	$("#addEmployee").click(function(){
		$('#employee-form')[0].reset();
		$('#employee-modal').modal('show');
		$('.modal-title').html("Add Employee");
		$('#action').val('addEmployee');
		$('#save').val('Add');
	});
	
	$("#employee-modal").on('submit','#employee-form', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		$.ajax({
			url:"advanced-employee-action.php",
			method:"POST",
			data:{
				ID: $('#ID').val(),
				email: $('#email').val(),
				phone: $('#phone').val(),
				dob: $('#dob').val(),
				address: $('#address').val(),
				action: $('#action').val(),
			},
			success:function(){
				$('#employee-modal').modal('hide');
				$('#employee-form')[0].reset();
				$('#save').attr('disabled', false);
				tableEmployee.ajax.reload();
			}
		})
	});		
	
	$("#table-employee").on('click', '.update', function(){
		var ID = $(this).attr("emp_id");
		var action = 'getEmployee';
		$.ajax({
			url:'advanced-employee-action.php',
			method:"POST",
			data:{ID:ID, action:action},
			dataType:"json",
			success:function(data){
				$('#employee-modal').modal('show');
				$('#ID').val(ID);
				$('#email').val(data.email);
				$('#phone').val(data.phone);
				$('#dob').val(data.dob);
				$('#address').val(data.address);
				$('.modal-title').html("Edit Employee");
				$('#action').val('updateEmployee');
				$('#save').val('Save');
			}
		})
	});
	
	$("#table-employee").on('click', '.delete', function(){
		var ID = $(this).attr("emp_id");		
		var action = "deleteEmployee";
		if(confirm("Are you sure you want to delete this employee?")) {
			$.ajax({
				url:'owner_functions_action.php',
				method:"POST",
				data:{ID:ID, action:action},
				success:function() {					
					tableEmployee.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});
