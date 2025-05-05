<?php 
session_start(); 
include('../database/config.php'); 

if (isset($_SESSION['username'])) { 
    $username = $_SESSION['username']; 
} else { 
    header("Location: login.php"); 
    exit(); 
} 

// Initialize an array to hold patient data 
$patients = []; 

// Fetch total number of patients
$totalPatientsQuery = "SELECT COUNT(*) as total FROM patients";
$totalResult = $conn->query($totalPatientsQuery);
$totalRow = $totalResult->fetch_assoc();
$totalPatients = $totalRow['total'];

// Pagination variables
$limit = 8; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit; // Offset for SQL query

// Fetch patient data from the database with limit and offset
$sql = "SELECT * FROM patients LIMIT $limit OFFSET $offset"; 
$result = $conn->query($sql); 

if ($result->num_rows > 0) { 
    while ($row = $result->fetch_assoc()) { 
        $patients[] = $row; 
    } 
} 

// Sort patients array by full_name 
usort($patients, function($a, $b) { 
    return strcmp($a['full_name'], $b['full_name']); 
}); 

// Close the database connection 
$conn->close(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Records</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: "Josefin Sans", sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Enable vertical scrolling */
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease; /* Smooth transition for sidebar */
        }

        .menu li {
            margin: 15px 0;
            position: relative; /* Position relative for submenu */
        }

        .menu li .submenu {
            max-height: 0; /* Set max-height to 0 for transition */
            opacity: 0; /* Set opacity to 0 for transition */
            overflow: hidden; /* Hide overflow */
            transition: max-height 0.5s ease, opacity 0.5s ease; /* Smooth transition for submenu */
            display: block; /* Keep the submenu in the flow */
        }

        .menu li .submenu.show {
            max-height: 175px; /* Set a larger max-height for the submenu */
            opacity: 1; /* Set opacity to 1 for transition */
        }

        .menu li span:hover {
            background-color: #34495e; /* Change background on hover */
            transition: background-color 0.3s ease; /* Smooth transition for background */
        }

        .menu li a:hover {
            background-color: #34495e; /* Change background on hover */
            transition: background-color 0.3s ease; /* Smooth transition for background */
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu {
            flex: 1;
            list-style-type: none;
        }

        

        .menu li span {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            cursor: pointer;
            padding: 10px;
            transition: background 0.3s;
        }

        .menu li span:hover {
            background-color: #34495e;
        }

        

        .menu li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
            transition: background 0.3s;
        }

        

        .logout {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .logout:hover {
            background-color: #34495e;
        }

        .header {
            background-color: #2980b9;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-bottom: 2px solid #1c598a;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1000;
        }

        .admin-info {
            font-size: 16px;
            font-weight: bold;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            margin-top: 70px;
            background-color: #ecf0f1;
        }

        h2, h3 {
            color: #2980b9;
            margin-bottom: 15px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3ddbd9;
            color: white;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .edit, .delete {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 0.9rem;
        }

        .edit {
            background-color: #28a745;
        }

        .edit:hover {
            background-color: #218838;
        }

        .delete {
            background-color: #dc3545;
        }

        .delete:hover {
            background-color: #c82333;
        }

        .filter-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .filter-container select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
            transition: border-color 0.3s;
        }

        .filter-container select:focus {
            border-color: #2980b9;
            outline: none;
        }

        .pagination-info {
            margin-top: 20px;
        }

        .pagination {
            margin-top: 10px;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #2980b9;
            color: #2980b9;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #2980b9;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>SCMS</h2>
            <ul class="menu">
                <li>
                    <span class="toggle dashboard"><i class="fa-solid fa-house"></i> Dashboard</span>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-hospital-user"></i> Patient</span>
                    <ul class="submenu">
                        <li><a href="patients.php">Add Patient</a></li>
                        <li><a href="view_records.php">View Records</a></li>
                        <li><a href="frequent_visits.php"></i> Frequent Visits</a></li>
                    </ul>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-capsules"></i> Medicine</span>
                    <ul class="submenu">
                        <li><a href="medicines.php">Add Medicines</a></li>
                        <li><a href="store_medicine.php">Search & Filter Medicines</a></li>
                        <li><a href="view_dispensed_medicines.php">View Dispensed Medicines</a></li>
                    </ul>
                </li>
                <li><a href="create_account.php"><i class="fa-solid fa-user"></i> Manage Account</a></li>
                <li><a href="#settings"><i class="fa-solid fa-gears"></i> Settings</a></li>
            </ul>
            <a href="login.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </aside>
        <header class="header">
            <div class="admin-info">ADMINISTRATOR, Hi <?php echo htmlspecialchars($username); ?></div>
        </header>
        
        <main class="main-content">
            <div class="header-container">
                <h2>Patient Records</h2>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search..." onkeyup ="filterTable()">
                </div>
                <div class="filter-container">
                    <select id="courseFilter" onchange="filterTable()">
                        <option value="">Course</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSCRIM">BSCRIM</option>
                        <option value="BSBA">BSBA</option>
                        <option value="BSED">BSED</option>
                        <option value="BEED">BEED</option>
                        <option value="BSTM">BSTM</option>
                        <option value="BSHM">BSHM</option>
                    </select>

                    <select id="yearLevelFilter" onchange="filterTable()">
                        <option value="">Year Level</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>

                    <select id="sectionFilter" onchange="filterTable()">
                        <option value="">Section</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>

                    <select id="semesterFilter" onchange="filterTable()">
                        <option value="">Semester</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                    </select>

                    <select id="academicYearFilter" onchange="filterTable()">
                        <option value="">Academic Year</option>
                        <option value="2025-2026">2025-2026</option>
                        <option value="2026-2027">2026-2027</option>
                        <option value="2027-2028">2027-2028</option>
                        <option value="2028-2029">2028-2029</option>
                        <option value="2029-2030">2029-2030</option>
                    </select>
                </div>
            </div>

            <div class="pagination-info">
                <p>Total Entries: <?php echo $totalPatients; ?></p>
            </div>

            <table id="patientTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Section</th>
                        <th>Semester</th>
                        <th>Academic Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['course']); ?></td>
                            <td><?php echo htmlspecialchars($patient['year_level']); ?></td>
                            <td><?php echo htmlspecialchars($patient['section']); ?></td>
                            <td><?php echo htmlspecialchars($patient['semester']); ?></td>
                            <td><?php echo htmlspecialchars($patient['academic_year']); ?></td>
                            <td class="actions">
                                <a href="update_records.php?id=<?php echo $patient['id']; ?>" class="edit"><i class="fa-solid fa-edit"></i> Edit</a>
                                <a href="delete_patient.php?id=<?php echo $patient['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa-solid fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php
                $totalPages = ceil($totalPatients / $limit);
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);
                
                if ($page > 1) {
                    echo '<a href="?page=1">«</a>';
                    echo '<a href="?page=' . ($page - 1) . '">‹</a>';
                }

                for ($i = $startPage; $i <= $endPage; $i++) {
                    echo '<a href="?page=' . $i . '" class="' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
                }

                if ($endPage < $totalPages) {
                    echo '...';
                    echo '<a href="?page=' . $totalPages . '">' . $totalPages . '</ a>';
                }

                if ($page < $totalPages) {
                    echo '<a href="?page=' . ($page + 1) . '">›</a>';
                }
                ?>
            </div>
        </main>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const courseFilter = document.getElementById('courseFilter').value;
            const yearLevelFilter = document.getElementById('yearLevelFilter').value;
            const sectionFilter = document.getElementById('sectionFilter').value;
            const semesterFilter = document.getElementById('semesterFilter').value;
            const academicYearFilter = document.getElementById('academicYearFilter').value;

            const filter = input.value.toLowerCase();
            const table = document.getElementById('patientTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdFullName = tr[i].getElementsByTagName('td')[0];
                const tdCourse = tr[i].getElementsByTagName('td')[1];
                const tdYearLevel = tr[i].getElementsByTagName('td')[2];
                const tdSection = tr[i].getElementsByTagName('td')[3];
                const tdSemester = tr[i].getElementsByTagName('td')[4];
                const tdAcademicYear = tr[i].getElementsByTagName('td')[5];

                const fullNameMatch = tdFullName && tdFullName.textContent.toLowerCase().indexOf(filter) > -1;
                const courseMatch = courseFilter === "" || (tdCourse && tdCourse.textContent === courseFilter);
                const yearLevelMatch = yearLevelFilter === "" || (tdYearLevel && tdYearLevel.textContent === yearLevelFilter);
                const sectionMatch = sectionFilter === "" || (tdSection && tdSection.textContent === sectionFilter);
                const semesterMatch = semesterFilter === "" || (tdSemester && tdSemester.textContent === semesterFilter);
                const academicYearMatch = academicYearFilter === "" || (tdAcademicYear && tdAcademicYear.textContent === academicYearFilter);

                if (fullNameMatch && courseMatch && yearLevelMatch && sectionMatch && semesterMatch && academicYearMatch) {
                    tr[i].style.display = ""; // Show the row
                } else {
                    tr[i].style.display = "none"; // Hide the row
                }
            }
        }

        // JavaScript to toggle submenu visibility
        const toggles = document.querySelectorAll('.toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                // Close all submenus
                toggles.forEach(t => {
                    const submenu = t.nextElementSibling;
                    if (submenu) {
                        submenu.classList.remove('show'); // Remove show class to close
                    }
                });

                // Open the clicked submenu
                const submenu = toggle.nextElementSibling;
                if (submenu) {
                    submenu.classList.toggle('show'); // Toggle show class to open/close
                }
            });
        });

        document.querySelector(".toggle.dashboard").addEventListener("click", function() {
            window.location.href = "dashboard.php";
        });
    </script>
</body>
</html>