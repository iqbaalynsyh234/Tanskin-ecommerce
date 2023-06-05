<?php
// Assuming you have a database connection established

// Fetch the subtotal from the database
$subtotal = fetchSubtotalFromDatabase();

// Return the subtotal as JSON response
header('Content-Type: application/json');
echo json_encode(['subtotal' => $subtotal]);

function fetchSubtotalFromDatabase() {
    // Replace with your database configuration
    $host = 'localhost';
    $dbname = 'tanskin';
    $username = 'root';
    $password = '';

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve the subtotal from the database
        // Replace 'orders' with your actual table name for orders
        $query = "SELECT SUM(subtotal) AS total FROM orders";

        // Prepare the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['total'])) {
            return $result['total'];
        } else {
            return null; // or handle the case where subtotal is not found
        }
    } catch (PDOException $e) {
        // Handle the database connection error
        // You can customize the error handling based on your requirements
        die("Database Error: " . $e->getMessage());
    }
}
?>
