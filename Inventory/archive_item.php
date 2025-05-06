<<<<<<< HEAD
<?php
include '../Config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$invID = $data['inventory_no'] ?? '';


if (empty($invID)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing inventory ID']);
    exit;
}

try {
    $conn->beginTransaction();

    // Move item to Archiveinv
    $insertSql = "INSERT INTO Archiveinv (AinvName, AinvDescription, AinvCategory, AinvDosage, AitemQuantity, AinvSupplyDate, AinvExpiryDate)
                  SELECT invName, invDescription, invCategory, invDosage, itemQuantity, invSupplyDate, invExpiryDate
                  FROM inventory WHERE invID = :invID";
    $stmtInsert = $conn->prepare($insertSql);
    $stmtInsert->execute([':invID' => $invID]);

    // Delete from inventory
    $deleteSql = "DELETE FROM inventory WHERE invID = :invID";
    $stmtDelete = $conn->prepare($deleteSql);
    $stmtDelete->execute([':invID' => $invID]);

    $conn->commit();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
=======
<?php
include '../Config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$invID = $data['inventory_no'] ?? '';


if (empty($invID)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing inventory ID']);
    exit;
}

try {
    $conn->beginTransaction();

    // Move item to Archiveinv
    $insertSql = "INSERT INTO Archiveinv (AinvName, AinvDescription, AinvCategory, AinvDosage, AitemQuantity, AinvSupplyDate, AinvExpiryDate)
                  SELECT invName, invDescription, invCategory, invDosage, itemQuantity, invSupplyDate, invExpiryDate
                  FROM inventory WHERE invID = :invID";
    $stmtInsert = $conn->prepare($insertSql);
    $stmtInsert->execute([':invID' => $invID]);

    // Delete from inventory
    $deleteSql = "DELETE FROM inventory WHERE invID = :invID";
    $stmtDelete = $conn->prepare($deleteSql);
    $stmtDelete->execute([':invID' => $invID]);

    $conn->commit();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
>>>>>>> 9af54f3f564a4b70b04f1491995f5037957eac8b
