<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = "select e.name as `name`, r.request_date as `request_date`, 
		r.reason as `reason`, r.start_date as `start_date`, 
		r.end_date as `end_date`, r.status as `status`, 
		r.reviewed_by as `reviewed_by` from employees e 
		join off_work_request r ON e.employee_ID = r.requested_by WHERE r.status != 'Pending' "; 
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        
        $numberRows = $stmt->rowCount();
        
        $dataTable = array();
        
        while ($sqlRow = $stmt->fetch()) {
            $dataRow = array();
            
            $dataRow[] = $sqlRow['name'];
            $dataRow[] = $sqlRow['request_date'];
            $dataRow[] = $sqlRow['reason'];
            $dataRow[] = $sqlRow['start_date'];
            $dataRow[] = $sqlRow['end_date'];
	$dataRow[] = $sqlRow['status'];
	$dataRow[] = $sqlRow['reviewed_by'];	
            $dataTable[] = $dataRow;
        }
        
        $output = array(
            "recordsTotal" => $numberRows,
            "recordsFiltered" => $numberRows,
            "data" => $dataTable
        );
        
        echo json_encode($output);
    }
}

$employee = new Employee();

if(!empty($_POST['action']) && $_POST['action'] == 'listEmployees') {
    $employee->listEmployees();
}

?>
