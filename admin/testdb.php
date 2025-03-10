<?php
// Start session for authentication
include('session.php');
include('admin_scripts.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier University Club Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <h1 class="dashboard-title">Dashboard</h1>
        
        <!-- Statistics Cards -->
        <div class="stat-cards">
            <div class="stat-card primary">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_members; ?></h3>
                    <p>Total Members</p>
                </div>
            </div>
            
            <div class="stat-card success">
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_clubs; ?></h3>
                    <p>Active Clubs</p>
                </div>
            </div>
            
            <div class="stat-card warning">
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_events; ?></h3>
                    <p>Upcoming Events</p>
                </div>
            </div>
            
            <div class="stat-card info">
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_news; ?></h3>
                    <p>News Articles</p>
                </div>
            </div>
        </div> 
</main>
</body>
</html>
<?php
$con->close();
?>