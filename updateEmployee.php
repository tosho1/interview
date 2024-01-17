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
        $result = updateEmployee($inputData);
        echo json_encode(['status' => 'success', 'message' => $result], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data'], JSON_PRETTY_PRINT);
    } 
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method'], JSON_PRETTY_PRINT);
}

// Function to update an employee
function updateEmployee($data) {
    global $conn;

   
    $employeeID = $data['EmployeeID'];
    $firstName = $data['FirstName'];
    $lastName = $data['LastName'];
    $hireDate = $data['HireDate'];
    // $position = $data['Position'];
    $department = $data['Department'];

    // Update employee data in Employees table
    $sql = "UPDATE Employees 
            SET FirstName='$firstName', LastName='$lastName', HireDate='$hireDate', Department='$department' 
            WHERE EmployeeID='$employeeID'";

    if (mysqli_query($conn, $sql)) {
        updateSalary($employeeID, $data['Salary']);
        updateDeductions($employeeID, $data['Deductions']);
        return "Employee updated successfully";
    } else {
        return "Error updating employee: " . mysqli_error($conn);
    }

 
}

// Function to update salary details for an employee
function updateSalary($employeeID, $salaryData) {
    global $conn;

    $baseSalary = $salaryData['BaseSalary'];
    $bonus = $salaryData['Bonus'];

    // Update salary data in Salary table
    $sql = "UPDATE Salary 
            SET BaseSalary='$baseSalary', Bonus='$bonus' 
            WHERE EmployeeID='$employeeID'";

    mysqli_query($conn, $sql);
}

// Function to update deduction details for an employee
function updateDeductions($employeeID, $deductionsData) {
    global $conn;

    $healthInsurance = $deductionsData['HealthInsurance'];
    $tax = $deductionsData['Tax'];

    // Update deduction data in Deductions table
    $sql = "UPDATE Deductions 
            SET HealthInsurance='$healthInsurance', Tax='$tax' 
            WHERE EmployeeID='$employeeID'";

    mysqli_query($conn, $sql);
}
?>
