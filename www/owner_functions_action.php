<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = "select e.employee_ID as `ID`, 
			e.name as `name`, 
			e.email as `email`, 
			e.phone as `phone`, 
			e.dob as `dob`, 
			e.Address as `address`, 
			e.job_title as `job_title`,
			e.wage as `wage` from employees e";
        
        if (! empty($_POST["search"]["value"])) {
            $sqlQuery .= 'WHERE (e.name LIKE "%' . $_POST["search"]["value"] . '%")';
        }
        
        if (! empty($_POST["order"])) {
            $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $sqlQuery .= 'ORDER BY e.employee_ID DESC ';
        }
        
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
            
            $dataRow[] = '<button type="button" name="update" emp_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>
                          <button type="button" name="delete" emp_id="' . $sqlRow["ID"] . '" class="btn btn-danger btn-sm delete" >Delete</button>';
            
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
            
            $sqlQuery = "select e.employee_ID as `ID`, 
			e.name as `name`, 
			e.email as `email`, 
			e.phone as `phone`, 
			e.dob as `dob`, 
			e.Address as `address`, 
			e.job_title as `job_title`, 
			e.wage as `wage` from employees e  
			WHERE e.employee_ID = :employee_ID";
            
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
                            name = :name,
                            email = :email,
                            phone = :phone,
                            dob = :dob,
			    Address = :address,
			job_title = :job_title,
			wage = :wage
                            WHERE employee_ID = :employee_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':name', $_POST["name"]);
            $stmt->bindValue(':email', $_POST["email"]);
            $stmt->bindValue(':phone', $_POST["phone"]);
            $stmt->bindValue(':dob', $_POST["dob"]);
            $stmt->bindValue(':address', $_POST["address"]);
		$stmt->bindValue(':job_title', $_POST["job_title"]);
		$stmt->bindValue(':wage', $_POST["wage"]);
            $stmt->bindValue(':employee_ID', $_POST["ID"]);
            $stmt->execute();
        }
    }
    
    public function addEmployee()
    {
        global $conn;
        
        $sqlQuery = "INSERT INTO employees
                     (name, email, phone, dob, Address, job_title, wage)
                     VALUES
                     (:name, :email, :phone, :dob, :address, :job_title, :wage)";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':name', $_POST["name"]);
        $stmt->bindValue('email', $_POST["email"]);
        $stmt->bindValue(':phone', $_POST["phone"]);
        $stmt->bindValue(':address', $_POST["address"]);
        $stmt->bindValue(':dob', $_POST["dob"]);
	$stmt->bindValue(':job_title', $_POST["job_title"]);
	$stmt->bindValue(':wage', $_POST["wage"]);
        $stmt->execute();
    }
    
    public function deleteEmployee()
    {
        global $conn;
        
        if ($_POST["ID"]) {
            
            $sqlQuery = "DELETE FROM job_history WHERE employee_ID = :employee_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':employee_ID', $_POST["ID"]);
            $stmt->execute();
            
            $sqlQuery = "DELETE FROM employees WHERE employee_ID = :employee_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':employee_ID', $_POST["ID"]);
            $stmt->execute();
        }
    }
}

$employee = new Employee();

if(!empty($_POST['action']) && $_POST['action'] == 'listEmployees') {
    $employee->listEmployees();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addEmployee') {
    $employee->addEmployee();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getEmployee') {
    $employee->getEmployee();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateEmployee') {
    $employee->updateEmployee();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteEmployee') {
    $employee->deleteEmployee();
}

?>
