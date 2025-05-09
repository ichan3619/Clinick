<?php
require '../Config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patients List</title>
  <link rel="stylesheet" href="../Stylesheet/doctorForm.css" />
  <script src="https://kit.fontawesome.com/503ea13a85.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="sidebar">
    <a href="nurseDashboard.php"><i class="fa-solid fa-house fa-3x"></i></a>
    <a href="#"><i class="fa-solid fa-hospital-user fa-3x"></i></a>
    <a href="#"><i class="fa-solid fa-stethoscope fa-3x"></i></a>
    <a href="#"><i class="fa-solid fa-box fa-3x"></i></a>
  </div>

  <div class="main">
    <nav>
      <a href="docDashboard.php">Dashboard</a>
      <a href="viewAppointments.php">Admission</a>
      <a href="../Inventory/INVDASH.html">Inventory</a>
    </nav>
    <br>
    <div class="appointments-container">
      <h2>Patients List | <?php echo date('F d, Y'); ?></h2>
      <table class="appointments-table">
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Contact Number</th>
            <th>Department</th>
            <th>Position</th>
          </tr>
        </thead>
        <tbody>
          <?php
          try {
            $query = "
              SELECT 
                CONCAT(pn.PatientFName, ' ', COALESCE(pn.PatientMName, ''), ' ', pn.PatientLName, ' ', COALESCE(pn.PatientSufix, '')) AS full_name,
                pi.Patient_ContactNum,
                d.dep_name,
                pp.position_name -- Fetching position_name from patient_positions table
              FROM patient_info pi
              JOIN patient_name pn ON pi.PatientName_Id = pn.PatientName_Id
              LEFT JOIN patient_departments d ON pi.depID = d.depID
              LEFT JOIN patient_positions pp ON pi.position_id = pp.position_id -- Added join for position table
              ORDER BY pn.PatientLName ASC
            ";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars(trim($row['full_name'])) . "</td>";
                echo "<td>" . htmlspecialchars($row['Patient_ContactNum']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dep_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['position_name']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4' style='text-align: center;'>No patients found</td></tr>"; 
            }
          } catch (PDOException $e) {
            echo "<tr><td colspan='4' style='text-align: center; color: red;'>Error: " . $e->getMessage() . "</td></tr>"; 
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <i class="fa-regular fa-user" id="profile"></i>

  <script src="../JScripts/index.js"></script>
</body>
</html>
<?php $conn = null; ?>
