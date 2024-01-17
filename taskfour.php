<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('dbconfig.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'GET') {
    $queryParams = $_GET;

    if (isset($queryParams['num_employee'])) {
        $result = getTotalEmployees();
        echo json_encode(['status' => 'success', 'num_employee' => $result], JSON_PRETTY_PRINT);
    } elseif (isset($queryParams['num_totalrole'])) {
        $result = getTotalRoles();
        echo json_encode(['status' => 'success', 'num_totalrole' => $result], JSON_PRETTY_PRINT);
        header("HTTP/1.0 200 ok");
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters'], JSON_PRETTY_PRINT);
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

// Function to retrieve the total number of employees
function getTotalEmployees() {
    global $conn;

    // Get the total number of employees
    $sql = "SELECT COUNT(*) AS totalEmployees FROM Employees";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);


    mysqli_close($conn);

    return $row['totalEmployees'];
}

// Function to retrieve the total available roles
function getTotalRoles() {
    global $conn;

    // Get the distinct roles from the Employees table
    $sql = "SELECT DISTINCT Role FROM Employees WHERE Role IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $roles = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row['Role'];
    }

    mysqli_close($conn);

    return count($roles);
}


?>
