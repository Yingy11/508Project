<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = "SELECT e.employee_ID as `ID`,
                            e.fullname as `name`,
                            e.email as `email`,
                            e.dob as `dob`,
			    e.Address as `address`
                     FROM employees e ";
        
        if (! empty($_POST["search"]["value"])) {
            $sqlQuery .= 'WHERE (e.fullname LIKE "%' . $_POST["search"]["value"] . '%") ';
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
            $dataRow[] = $sqlRow['dob'];
            $dataRow[] = $sqlRow['address'];
            
            
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
            
            $sqlQuery = "SELECT employee_ID as `ID`,
                            first_name,
                            last_name,
                            salary,
                            manager_ID,
                            department_ID,
                            email,
                            job_ID
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
                            first_name = :first_name,
                            last_name = :last_name,
                            manager_ID = :manager_ID,
                            department_ID = :department_ID,
                            email = :email,
                            job_ID = :job_ID,
                            salary = :salary
                            WHERE employee_ID = :employee_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':first_name', $_POST["firstname"]);
            $stmt->bindValue(':last_name', $_POST["lastname"]);
            $stmt->bindValue(':manager_ID', $_POST["manager"]);
            $stmt->bindValue(':department_ID', $_POST["department"]);
            $stmt->bindValue(':email', $_POST["email"]);
            $stmt->bindValue(':job_ID', $_POST["job"]);
            $stmt->bindValue(':salary', $_POST["salary"]);
            $stmt->bindValue(':employee_ID', $_POST["ID"]);
            $stmt->execute();
        }
    }
    
    public function addEmployee()
    {
        global $conn;
        
        $sqlQuery = "INSERT INTO employees
                     (first_name, last_name, manager_ID, department_ID, email, job_ID, salary, hire_date)
                     VALUES
                     (:first_name, :last_name, :manager_ID, :department_ID, :email, :job_ID, :salary, CURDATE())";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':first_name', $_POST["firstname"]);
        $stmt->bindValue(':last_name', $_POST["lastname"]);
        $stmt->bindValue(':manager_ID', $_POST["manager"]);
        $stmt->bindValue(':department_ID', $_POST["department"]);
        $stmt->bindValue(':email', $_POST["email"]);
        $stmt->bindValue(':job_ID', $_POST["job"]);
        $stmt->bindValue(':salary', $_POST["salary"]);
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
