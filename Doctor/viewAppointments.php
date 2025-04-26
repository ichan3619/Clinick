<?php
  require '../Config/database.php';  // Adjusted for the new location of the 'Config' folder
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="../Stylesheet/doctorForm.css">  <!-- Adjusted for the new location of 'Stylesheet' -->
    <script src="https://kit.fontawesome.com/503ea13a85.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sidebar">
        <a href="../reqConsult.php"><i class="fa-solid fa-notes-medical fa-3x" title="Request Consultation"></i></a>  <!-- Adjusted for the new location -->
        <a href="../viewSum.php"><i class="fa-solid fa-clock-rotate-left fa-3x" title="History"></i></a>  <!-- Adjusted for the new location -->
        <a href="viewAppointments.php" class="active"><i class="fa-solid fa-calendar-check fa-3x" title="Appointments"></i></a>
    </div>

    <div class="main">
        <nav>
            <a href="../patientHome.php">Dashboard</a>  <!-- Adjusted for the new location -->
            <a href="#" class="active">Admission</a>
        </nav>
        <br>
        <div class="appointments-container">
            <h2>My Patients | <?php echo date('F d, Y'); ?></h2>
            
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>School No.</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Date of Appointment</th>
                        <th>Visit Status</th>
                        <th>Type of Visit</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $query = "SELECT 
                                    a.id,
                                    p.campusID as school_no,
                                    CONCAT(p.firstName, ' ', COALESCE(p.lastName, '')) as patient_name,
                                    pos.position_name,
                                    dept.name as department,
                                    DATE_FORMAT(a.appointment_date, '%Y-%m-%d %H:%i:%s') as appointment_date,
                                    CASE 
                                        WHEN a.status = 'Scheduled' THEN 'Follow-Up'
                                        WHEN a.status = 'Completed' THEN 'New Patient'
                                    END as visit_status,
                                    a.type_of_admission,
                                    CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                                    a.status,
                                    a.link
                                FROM appointments a
                                JOIN patientsInfo p ON a.patient_id = p.patientID
                                JOIN patient_departments dept ON a.dept_id = dept.id
                                JOIN doctors d ON a.doctor_id = d.id
                                JOIN patient_positions pos ON dept.position_id = pos.id
                                ORDER BY a.appointment_date DESC";
                        
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        
                        if ($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['school_no']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                                echo "<td>" . ucfirst(htmlspecialchars($row['position_name'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                                echo "<td>" . date('Y-m-d H:i:s', strtotime($row['appointment_date'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['visit_status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['type_of_admission']) . "</td>";
                                echo "<td>Doc. " . htmlspecialchars($row['doctor_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>";
                                if (!empty($row['link'])) {
                                    echo "<a href='" . htmlspecialchars($row['link']) . "' target='_blank' class='meeting-link'>";
                                    echo "<i class='fa-solid fa-video'></i> Join";
                                    echo "</a>";
                                }
                                echo "</td>";
                                echo "<td>";
                                if ($row['status'] === 'Scheduled') {
                                    echo "<span class='action-icons'>";
                                    echo "<i class='fa-solid fa-check' style='color: #4CAF50;'></i>";
                                    echo "<i class='fa-solid fa-xmark' style='color: #f44336;'></i>";
                                    echo "</span>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11' style='text-align: center;'>No appointments found</td></tr>";
                        }
                    } catch(PDOException $e) {
                        echo "<tr><td colspan='11' style='text-align: center; color: red;'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <i class="fa-regular fa-user" id="profile"></i>
</body>
</html>
<?php
  $conn = null;
?>
