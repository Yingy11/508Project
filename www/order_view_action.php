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
				e.ordered_by as `ordered_by`
			 FROM orders e";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        
        $numberRows = $stmt->rowCount();
        
        $dataTable = array();
        
        while ($sqlRow = $stmt->fetch()) {
            $dataRow = array();
            
            $dataRow[] = $sqlRow['ID'];
            $dataRow[] = $sqlRow['item_name'];
            $dataRow[] = $sqlRow['quantity'];
            $dataRow[] = $sqlRow['order_date'];
            $dataRow[] = $sqlRow['arrival_date'];
	$dataRow[] = $sqlRow['ordered_by'];
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


