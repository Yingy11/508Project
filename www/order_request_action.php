<?php
require_once ('connection.php');

class Employee
{
    public function listEmployees()
    {
        global $conn;
        
        $sqlQuery = "SELECT request_date as `request_date`, item_name as `item_name`, 
	quantity as `quantity`, reason as `reason`, `status` as `status`, reviewed_by as `reviewed_by`
	FROM order_request WHERE requested_by = '{$_SESSION['user_ID']}' ";
       

	if (! empty($_POST["search"]["value"])) {
            $sqlQuery .= 'WHERE (`status` LIKE "%' . $_POST["search"]["value"] . '%" ) ';
        }
        
        if (! empty($_POST["order"])) {
            $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $sqlQuery .= 'ORDER BY request_date DESC ';
        }

	 $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        
        $numberRows = $stmt->rowCount();
        
        $dataTable = array();
        
        while ($sqlRow = $stmt->fetch()) {
            $dataRow = array();
            $dataRow[] = $sqlRow['request_date'];
            $dataRow[] = $sqlRow['item_name'];
            $dataRow[] = $sqlRow['quantity'];
	$dataRow[] = $sqlRow['reason'];
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



 public function addEmployee()
    {
        global $conn;
        
        $sqlQuery = "INSERT INTO order_request
                     (requested_by, request_date, reason, item_name, quantity)
                     VALUES
                     ('{$_SESSION['user_ID']}', CURDATE(), :reason, :item_name, :quantity)";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':reason', $_POST["reason"]);
        $stmt->bindValue(':item_name', $_POST["item_name"]);
        $stmt->bindValue(':quantity', $_POST["quantity"]);
        $stmt->execute();
    }













}

$employee = new Employee();

if(!empty($_POST['action']) && $_POST['action'] == 'listEmployees') {
    $employee->listEmployees();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addEmployee') {
    $employee->addEmployee();
}

?>
