<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbconfig.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'GET') {
    $queryParams = $_GET;
    
    if (isset($queryParams['id'])) {
        $result = findEmployeeByID($queryParams['id']);
        echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
    } elseif (isset($queryParams['name'])) {
        $result = findEmployeeByName($queryParams['name']);
        echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
    } else {
        // echo json_encode(['status' => 'error', 'message' => 'Invalid parameters'], JSON_PRETTY_PRINT);
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

// Function to find an employee by name
function findEmployeeByName($name) {
    global $conn;


    // Find employee by name in Employees table
    $sql = "SELECT * FROM Employees WHERE CONCAT(FirstName, ' ', LastName) LIKE '%$name%'";

    $result = mysqli_query($conn, $sql);
    $employees = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $employees[] = $row;
    }

    
    mysqli_close($conn);

    return $employees;
}

// Function to find an employee by ID
function findEmployeeByID($employeeID) {
    global $conn;

    // Find employee by ID in Employees table
    $sql = "SELECT * FROM Employees WHERE EmployeeID='$employeeID'";

    $result = mysqli_query($conn, $sql);
    $employee = mysqli_fetch_assoc($result);

    mysqli_close($conn);

    return $employee;
}

?>
