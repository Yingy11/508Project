$(document).ready(function(){
	
	$('#table-employee').DataTable({
		"dom": 'Blfrtip',
		"ordering":false,
		"bLengthChange": false,
		"searching": false,
		"paging": false,
		"ajax":{
			url:"basic-employee-action.php",
			type:"POST",
			data:{
					action:'listEmployees'
				 },
			dataType:"json"
		}
	});
	
});