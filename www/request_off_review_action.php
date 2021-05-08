<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = " SELECT r.request_ID as `ID`,
			e.name as `name`, r.request_date as `request_date`, 
			r.reason as `reason`, r.start_date as `start_date`, 
			r.end_date as `end_date`, r.status as `status` 
			from  off_work_request r JOIN employees e 
			ON r.requested_by = e.employee_ID 
			WHERE r.status = 'Pending'";
        
        if (! empty($_POST["search"]["value"])) {
            $sqlQuery .= 'WHERE (e.name LIKE "%' . $_POST["search"]["value"] . '%") ';
        }
        
        if (! empty($_POST["order"])) {
            $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $sqlQuery .= 'ORDER BY r.request_date DESC ';
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
            $dataRow[] = $sqlRow['request_date'];
            $dataRow[] = $sqlRow['reason'];
            $dataRow[] = $sqlRow['start_date'];
            $dataRow[] = $sqlRow['end_date'];
            $dataRow[] = $sqlRow['status'];
            
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
            $sqlQuery = "SELECT request_ID as `ID`,
                           `status`
                     FROM off_work_request
                     WHERE request_ID = :request_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':request_ID', $_POST["ID"]);
            $stmt->execute();
            echo json_encode($stmt->fetch());
        }
    }
    
    public function updateEmployee()
    {
        global $conn;
        $reviewed_by = $conn -> query("SELECT name FROM employees WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();

        if ($_POST['ID']) {
            
            $sqlQuery = "UPDATE off_work_request
                            SET
                            status = :status,
                            reviewed_by = '{$reviewed_by[0]}'
                            WHERE request_ID = :request_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':status', $_POST["status"]);
            $stmt->bindValue(':request_ID', $_POST["ID"]);
            $stmt->execute();
        }
    }
    
    public function addEmployee()
    {
        global $conn;
        
        $sqlQuery = "INSERT INTO employees
                     (name, email, phone, dob, address, job_title, wage)
                     VALUES
                     (:name, :email, :phone, :dob, :address, :job_title, :wage)";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':name', $_POST["name"]);
        $stmt->bindValue(':email', $_POST["email"]);
        $stmt->bindValue(':phone', $_POST["phone"]);
        $stmt->bindValue(':dob', $_POST["dob"]);
        $stmt->bindValue(':address', $_POST["address"]);
        $stmt->bindValue(':job_title', $_POST["job_title"]);
        $stmt->bindValue(':wage', $_POST["wage"]);
        $stmt->execute();
    }
    
    public function deleteEmployee()
    {
        global $conn;
        
        if ($_POST["ID"]) {
            
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
