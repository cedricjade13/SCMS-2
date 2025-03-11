<?php
session_start(); // Start the session

// Include the database configuration file
include('../database/config.php'); // Make sure this path is correct

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Get the username from the session
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch daily patient statistics
$dailyStats = [];
$sql = "SELECT DATE(created_at) AS date, COUNT(*) AS count 
        FROM patients 
        GROUP BY date 
        ORDER BY date ASC"; // Change DESC to ASC for past -> present
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $dailyStats[] = $row;
}

// Fetch weekly patient statistics
$weeklyStats = [];
$sql = "SELECT YEAR(created_at) AS year, WEEK(created_at) AS week, COUNT(*) AS count 
        FROM patients 
        GROUP BY year, week 
        ORDER BY year ASC, week ASC"; // Change DESC to ASC for past -> present
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $weeklyStats[] = $row;
}

// Fetch monthly patient statistics
$monthlyStats = [];
$sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count 
        FROM patients 
        GROUP BY month 
        ORDER BY month ASC"; // Change DESC to ASC for past -> present
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $monthlyStats[] = $row;
}

// Fetch yearly patient statistics
$yearlyStats = [];
$sql = "SELECT YEAR(created_at) AS year, COUNT(*) AS count 
        FROM patients 
        GROUP BY year 
        ORDER BY year ASC"; // Change DESC to ASC for past -> present
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $yearlyStats[] = $row;
}

// Prepare data for the charts
// Daily
$dailyLabels = array_column($dailyStats, 'date');
$dailyCounts = array_column($dailyStats, 'count');

// Weekly
$weeklyLabels = [];
$weeklyCounts = [];
foreach ($weeklyStats as $stat) {
    $weeklyLabels[] = "W" . $stat['week'] . " " . $stat['year'];
    $weeklyCounts[] = (int)$stat['count'];
}

// Monthly
$monthlyLabels = array_column($monthlyStats, 'month');
$monthlyCounts = array_column($monthlyStats, 'count');

// Yearly
$yearlyLabels = array_column($yearlyStats, 'year');
$yearlyCounts = array_column($yearlyStats, 'count');

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
    <style>
        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .chart {
            width: 48%; /* Two charts side by side */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>SCMS</h2>
            <ul class="menu">
                <li>
                    <span class="toggle"><i class="fa-solid fa-house"></i> Dashboard</span>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-hospital-user"></i> Patient</span>
                    <ul class="submenu">
                        <li><a href="patients.php">Add Patient</a></li>
                        <li><a href="view_records.php">View Records</a></li>
                        <li><a href="#search-filter-patients">Search & Filter Patients</a></li>
                        <li><a href="#edit-patient-info">Edit Patient Information</a></li>
                    </ul>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-capsules"></i> Medicine</span>
                    <ul class="submenu">
                        <li><a href="medicines.php">Add Medicines</a></li>
                        <li><a href="#search-filter-medicines">Search & Filter Medicines</a></li>
                        <li><a href="#expiry-date-tracking">Expiry Date Tracking</a></li>
                    </ul>
                </li>
                <li><a href="#settings"><i class="fa-solid fa-gears"></i> Settings</a></li>
            </ul>
            <a href="login.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </aside>
        
        <header class="header">
            <div class="admin-info">ADMINISTRATOR, Hi <?php echo htmlspecialchars($username); ?></div> <!-- Display the username -->
        </header>
        
        <main class="main-content">
            <h2>Patient Statistics</h2>
            <div class="chart-container">
                <div class="chart">
                    <canvas id="dailyChart"></canvas> <!-- Canvas for daily chart -->
                </div>
                <div class="chart">
                    <canvas id="weeklyChart"></canvas> <!-- Canvas for weekly chart -->
                </div>
                <div class="chart">
                    <canvas id="monthlyChart"></canvas> <!-- Canvas for monthly chart -->
                </div>
                <div class="chart">
                    <canvas id="yearlyChart"></canvas> <!-- Canvas for yearly chart -->
                </div>
            </div>

            <script>
                // Daily Chart
                const dailyLabels = <?php echo json_encode($dailyLabels); ?>;
                const dailyCounts = <?php echo json_encode($dailyCounts); ?>;
                const dailyCtx = document.getElementById('dailyChart').getContext('2d');
                new Chart(dailyCtx, {
                    type: 'line',
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                            label: 'Daily Patients',
                            data: dailyCounts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Patients'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        }
                    }
                });

                // Weekly Chart
                const weeklyLabels = <?php echo json_encode($weeklyLabels); ?>;
                const weeklyCounts = <?php echo json_encode($weeklyCounts); ?>;
                const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
                new Chart(weeklyCtx, {
                    type: 'line',
                    data: {
                        labels: weeklyLabels,
                        datasets: [{
                            label: 'Weekly Patients',
                            data: weeklyCounts,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Patients'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks'
                                }
                            }
                        }
                    }
                });

                // Monthly Chart
                const monthlyLabels = <?php echo json_encode($monthlyLabels); ?>;
                const monthlyCounts = <?php echo json_encode($monthlyCounts); ?>;
                const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
                new Chart(monthlyCtx, {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: 'Monthly Patients',
                            data: monthlyCounts,
                            borderColor: 'rgba(255, 159, 64, 1)',
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Patients'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Months'
                                }
                            }
                        }
                    }
                });

                // Yearly Chart
                const yearlyLabels = <?php echo json_encode($yearlyLabels); ?>;
                const yearlyCounts = <?php echo json_encode($yearlyCounts); ?>;
                const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
                new Chart(yearlyCtx, {
                    type: 'line',
                     data: {
                        labels: yearlyLabels,
                        datasets: [{
                            label: 'Yearly Patients',
                            data: yearlyCounts,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Patients'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Years'
                                }
                            }
                        }
                    }
                });
            </script>
        </main>
    </div>

    <script>
        // JavaScript to toggle submenu visibility
        const toggles = document.querySelectorAll('.toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const submenu = toggle.nextElementSibling;
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>