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
			e.wage as `wage` from employees e WHERE e.employee_ID = {$_SESSION["user_ID"]} ";
        
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        
        $numberRows = $stmt->rowCount();
        
        if ($_POST["length"] != - 1) {
            $sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        
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
            
            $dataRow[] = '<button type="button" name="update" emp_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>';
            
            $dataTable[] = $dataRow;
        }
        
        $output = array(
            "recordsTotal" => $numberRows,
            "recordsFiltered" => $numberRows,
            "data" => $dataTable
        );
        
        echo json_encode($output);
    }
    
    public function getEmployee()
    {
        global $conn;
        
        if ($_POST["ID"]) {
            
            $sqlQuery = "SELECT employee_ID as `ID`,
                            name,
                            email,
                            phone,
                            dob,
                            address,
                            job_title,
                            wage
                     FROM employees
                     WHERE employee_ID = :employee_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':employee_ID', $_POST["ID"]);
            $stmt->execute();
            
            echo json_encode($stmt->fetch());
        }
    }
    
    public function updateEmployee()
    {
        global $conn;
        
        if ($_POST['ID']) {
            
            $sqlQuery = "UPDATE employees
                            SET
                            email = :email,
                            phone = :phone,
                            dob = :dob,
                            address = :address,
                            WHERE employee_ID = :employee_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':phone', $_POST["phone"]);
            $stmt->bindValue(':email', $_POST["email"]);
            $stmt->bindValue(':dob', $_POST["dob"]);
            $stmt->bindValue(':address', $_POST["address"]);
            $stmt->bindValue(':employee_ID', $_POST["ID"]);
            $stmt->execute();
        }
    }
    
    



}

$employee = new Employee();

if(!empty($_POST['action']) && $_POST['action'] == 'listEmployees') {
    $employee->listEmployees();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getEmployee') {
    $employee->getEmployee();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateEmployee') {
    $employee->updateEmployee();
}

?>
