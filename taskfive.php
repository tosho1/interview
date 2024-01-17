<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');


include('dbconfig.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    
    if ($inputData && isset($inputData['employeeID']) && isset($inputData['status'])) {
        $result = updateEmployeeStatus($inputData['employeeID'], $inputData['status']);
        echo json_encode(['status' => 'success', 'message' => $result], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data'], JSON_PRETTY_PRINT);
    } 
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method'], JSON_PRETTY_PRINT);
}

// Function to update the status of an employee (employed or fired)
function updateEmployeeStatus($employeeID, $status) {
    global $conn;


    // Validate the status
    $validStatus = ['employed', 'fired'];
    if (!in_array($status, $validStatus)) {
        return 'Invalid status specified';
    }

    // Update employee status in Employees table
    $sql = "UPDATE Employees SET Status='$status' WHERE EmployeeID='$employeeID'";

    if (mysqli_query($conn, $sql)) {
        return "Employee status updated successfully";
    } else {
        return "Error updating employee status: " . mysqli_error($conn);
    }

 

}


?>
