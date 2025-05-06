<<<<<<< HEAD
<?php
// Include the database connection
include '../Config/database.php';

// Get the search term and category from the URL (if set)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Start building the query
$query = "SELECT * FROM Archiveinv WHERE 1=1";

// If a category is selected, filter by category
if ($category != '') {
    $query .= " AND AinvCategory = :category";
}

// If a search term is provided, filter by Inventory ID or Name
if ($search != '') {
    $query .= " AND (AinvID LIKE :search OR AinvName LIKE :search)";
}

try {
    // Prepare and execute the query
    $stmt = $conn->prepare($query);

    // Bind the parameters
    if ($category != '') {
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    }
    if ($search != '') {
        $searchTerm = "%" . $search . "%"; // Add wildcards to the search term
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the results as an associative array
    $inventoryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as a JSON response
    echo json_encode($inventoryItems);

} catch (PDOException $e) {
    // Handle any database errors
    echo json_encode(['error' => 'Failed to fetch data: ' . $e->getMessage()]);
}
?>
=======
<?php
// Include the database connection
include '../Config/database.php';

// Get the search term and category from the URL (if set)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Start building the query
$query = "SELECT * FROM Archiveinv WHERE 1=1";

// If a category is selected, filter by category
if ($category != '') {
    $query .= " AND AinvCategory = :category";
}

// If a search term is provided, filter by Inventory ID or Name
if ($search != '') {
    $query .= " AND (AinvID LIKE :search OR AinvName LIKE :search)";
}

try {
    // Prepare and execute the query
    $stmt = $conn->prepare($query);

    // Bind the parameters
    if ($category != '') {
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    }
    if ($search != '') {
        $searchTerm = "%" . $search . "%"; // Add wildcards to the search term
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the results as an associative array
    $inventoryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as a JSON response
    echo json_encode($inventoryItems);

} catch (PDOException $e) {
    // Handle any database errors
    echo json_encode(['error' => 'Failed to fetch data: ' . $e->getMessage()]);
}
?>
>>>>>>> 9af54f3f564a4b70b04f1491995f5037957eac8b
