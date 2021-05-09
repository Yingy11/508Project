<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = "SELECT e.order_ID as `ID`,
                            e.item_name as `item_name`,
                            e.quantity as `quantity`,
                            e.order_date as `order_date`,
			    e.arrival_date as `arrival_date`,
			e.cost as `cost`,
			e.ordered_by as `ordered_by`
                     FROM orders e ";
        
        if (! empty($_POST["search"]["value"])) {
            $sqlQuery .= 'WHERE (e.item_name LIKE "%' . $_POST["search"]["value"] . '%" or e.ordered_by LIKE "%' . $_POST["search"]["value"] . '%") ';
        }
        
        if (! empty($_POST["order"])) {
            $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $sqlQuery .= 'ORDER BY e.order_ID DESC ';
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
            $dataRow[] = $sqlRow['item_name'];
            $dataRow[] = $sqlRow['quantity'];
            $dataRow[] = $sqlRow['order_date'];
            $dataRow[] = $sqlRow['arrival_date'];
            $dataRow[] = $sqlRow['cost'];
            $dataRow[] = $sqlRow['ordered_by'];
	  
            
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
            
            $sqlQuery = "SELECT order_ID as `ID`,
                            item_name,
                            quantity,
                            order_date,
                            arrival_date,
                            cost
                     FROM orders
                     WHERE order_ID = :order_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':order_ID', $_POST["ID"]);
            $stmt->execute();
            
            echo json_encode($stmt->fetch());
        }
    }
    
    public function updateEmployee()
    {
        global $conn;
        
        if ($_POST['ID']) {
            
            $sqlQuery = "UPDATE orders
                            SET
                            item_name = :item_name,
                            quantity = :quantity,
                            order_date = :order_date,
                            arrival_date = :arrival_date,
                            cost = :cost
                            WHERE order_ID = :order_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':item_name', $_POST["item_name"]);
            $stmt->bindValue(':quantity', $_POST["quantity"]);
            $stmt->bindValue(':order_date', $_POST["order_date"]);
            $stmt->bindValue(':arrival_date', $_POST["arrival_date"]);
            $stmt->bindValue(':cost', $_POST["cost"]);
            $stmt->bindValue(':order_ID', $_POST["ID"]);
            $stmt->execute();
        }
    }
    
    public function addEmployee()
    {
        global $conn;
        $ordered_by = $conn -> query("SELECT name FROM employees WHERE employee_ID = {$_SESSION['user_ID']}")->fetch();

        $sqlQuery = "INSERT INTO orders
                     (item_name, quantity, order_date, arrival_date, cost, ordered_by)
                     VALUES
                     (:item_name, :quantity, :order_date, :arrival_date, :cost, '{$ordered_by[0]}')";
        if( empty($_POST["arrival_date"]) ){
		$_POST["arrival_date"] = null;
	}
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':item_name', $_POST["item_name"]);
        $stmt->bindValue(':quantity', $_POST["quantity"]);
        $stmt->bindValue(':order_date', $_POST["order_date"]);
        $stmt->bindValue(':arrival_date', $_POST["arrival_date"]);
        $stmt->bindValue(':cost', $_POST["cost"]);
        $stmt->execute();
    }
    
    public function deleteEmployee()
    {
        global $conn;
        
        if ($_POST["ID"]) {
            
            $sqlQuery = "DELETE FROM orders WHERE order_ID = :order_ID";
            
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(':order_ID', $_POST["ID"]);
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
