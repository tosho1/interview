<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbconfig.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if ($inputData) {
        $result = assignRole($inputData);
        echo json_encode(['status' => 'success', 'message' => $result], JSON_PRETTY_PRINT);
    } else {
        // echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data'], JSON_PRETTY_PRINT);
        $data = [
            'status' => 500,
            'message' =>'Invalid JSON data'
        ];
        header("HTTP/1.0 500 INTERNAL SERVER ERROR");
        echo json_encode($data);
    }
} else {
    // echo json_encode(['status' => 'error', 'message' => 'Invalid request method'], JSON_PRETTY_PRINT);
    $data = [
        'status' => 405,
        'message' => $requestMethod .' '. 'METHOD NOT ALLOW'
    ];
    header("HTTP/1.0 405 Method Not Allow");
    echo json_encode($data);
}

// Function to assign a role to an employee
function assignRole($data) {
    global $conn;

    $employeeID = $data['EmployeeID'];
    $role = $data['Role'];

    // Validate the role
    $validRoles = ['manager', 'developer', 'design', 'scrum master'];   
    if (!in_array($role, $validRoles)) {
        return "Invalid role. Valid roles are: manager, developer, design, scrum master";
    }

    // Update employee role in Employees table
    $sql = "UPDATE Employees 
            SET Role='$role' 
            WHERE EmployeeID='$employeeID'";

    if (mysqli_query($conn, $sql)) {
        return "Role assigned successfully";
    } else {
        return "Error assigning role: " . mysqli_error($conn);
    }

    // Close connection (make sure to close it at the end of your script)
    // mysqli_close($conn);
}



?>
