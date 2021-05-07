<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = "SELECT e.employee_ID as `ID`,
                            e.name as `name`,
                            e.email as `email`,
                            e.phone as `phone`,
                            e.dob as `dob`,
				e.address as `address`,
				e.job_title as `job_title`,
				e.wage as `wage`
                     FROM employees e";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        
        $numberRows = $stmt->rowCount();
        
        $dataTable = array();
        
        while ($sqlRow = $stmt->fetch()) {
            $dataRow = array();
            
            $dataRow[] = $sqlRow['ID'];
            $dataRow[] = $sqlRow['name'];
            $dataRow[] = $sqlRow['email'];
            $dataRow[] = $sqlRow['phone'];
            $dataRow[] = $sqlRow['dob'];
	$dataRow[] = $sqlRow['address'];
	$dataRow[] = $sqlRow['job_title'];	
            $dataRow[] = $sqlRow['wage'];
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
