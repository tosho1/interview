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
        $result = createEmployee($inputData);
        $data = [
            'status' => 200,
            'message' =>'Employee add successfully' 
        ];
        header("HTTP/1.0 201 Created");
        echo  json_encode($data);
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
    $data = [
        'status' => 405,
        'message' => $requestMethod .' '. 'METHOD NOT ALLOW'
    ];
    header("HTTP/1.0 405 Method Not Allow");
    echo json_encode($data);
}

// Function to create an employee
function createEmployee($data) {
    global $conn;

    

    $firstName = $data['FirstName'];
    $lastName = $data['LastName'];
    // $hireDate = $data['HireDate'];
    $hireDate = date("Y-m-d H:i:s");
    // $position = $data['Position'];
    $department = $data['Department'];

    // Insert employee data into Employees table
    $sql = "INSERT INTO Employees (FirstName, LastName, HireDate, Department) 
            VALUES ('$firstName', '$lastName', '$hireDate', '$department')";

    if (mysqli_query($conn, $sql)) {
        $employeeID = mysqli_insert_id($conn);
        createSalary($employeeID, $data['Salary']);
        createDeductions($employeeID, $data['Deductions']);
        return "Employee created successfully";
    } else {
        return "Error creating employee: " . mysqli_error($conn);
    }

    // mysqli_close($conn);
}

// Function to create salary details for an employee
function createSalary($employeeID, $salaryData) {
    global $conn;

    $baseSalary = $salaryData['BaseSalary'];
    $bonus = $salaryData['Bonus'];

    // Insert salary data into Salary table
    $sql = "INSERT INTO Salary (EmployeeID, BaseSalary, Bonus) 
            VALUES ('$employeeID', '$baseSalary', '$bonus')";

    mysqli_query($conn, $sql);
}

// Function to create deduction details for an employee
function createDeductions($employeeID, $deductionsData) {
    global $conn;

    $healthInsurance = $deductionsData['HealthInsurance'];
    $tax = $deductionsData['Tax'];

    // Insert deduction data into Deductions table
    $sql = "INSERT INTO Deductions (EmployeeID, HealthInsurance, Tax) 
            VALUES ('$employeeID', '$healthInsurance', '$tax')";

    mysqli_query($conn, $sql);
}


?>
