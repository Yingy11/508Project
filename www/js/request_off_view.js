$(document).ready(function(){
	
	$('#table-employee').DataTable({
		"dom": 'Blfrtip',
		"ordering":false,
		"bLengthChange": false,
		"searching": false,
		"paging": false,
		"ajax":{
			url:"request_off_view_action.php",
			type:"POST",
			data:{
					action:'listEmployees'
				 },
			dataType:"json"
		}
	});
	
});
