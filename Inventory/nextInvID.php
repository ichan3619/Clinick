<<<<<<< HEAD
<?php
include '../Config/database.php';

try {
    // Query to get the max ID from both tables
    $sql = "
        SELECT MAX(id_val) AS max_id FROM (
            SELECT MAX(invID) AS id_val FROM inventory
            UNION
            SELECT MAX(AinvID) AS id_val FROM archiveinv
        ) AS combined
    ";

    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $nextId = $row['max_id'] ? $row['max_id'] + 1 : 1;

    echo json_encode(["next_id" => $nextId]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
=======
<?php
include '../Config/database.php';

try {
    // Query to get the max ID from both tables
    $sql = "
        SELECT MAX(id_val) AS max_id FROM (
            SELECT MAX(invID) AS id_val FROM inventory
            UNION
            SELECT MAX(AinvID) AS id_val FROM archiveinv
        ) AS combined
    ";

    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $nextId = $row['max_id'] ? $row['max_id'] + 1 : 1;

    echo json_encode(["next_id" => $nextId]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
>>>>>>> 9af54f3f564a4b70b04f1491995f5037957eac8b
