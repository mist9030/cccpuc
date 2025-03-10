<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM admin WHERE email='$email'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found!";
    exit();
}

function processImageUpload($image, $filePath) {
    $ext = explode(".", $image['name']);
    $ext = end($ext);
    $date = date("D:M:Y");
    $time = date("h:i:s");
    $image11 = md5($date . $time);
    $imagename = $image11 . "." . $ext;

    if (move_uploaded_file($image['tmp_name'], "$filePath$imagename")) {
        return $imagename;
    }
    return null;
}
if(isset($_POST['news']))
{
    $title = $_POST['title'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $clubs = $_POST['clubs'];
    $image = $_FILES['image'];

    $filePath = "../upload/news/";
    $imagename = processImageUpload($image, $filePath);

	
	$query="insert into news (title, date, image, category, clubs) values( '$title', '$date', '$imagename', '$category', '$clubs')";
	if(mysqli_query($con,$query))
	{
		echo "Successfully inserted!";
        header("Location:dashboard.php");

    }
	else
	{
		echo "error!".mysqli_error($con);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add News Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-container {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-title {
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="file"] {
            padding: 8px 0;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #4CAF50;
            padding: 10px;
            background: #e8f5e9;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error-message {
            color: #f44336;
            padding: 10px;
            background: #ffebee;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="form-container">
    <?php include("navbar.php");?>

<?php include("aside.php");?>
        <h2 class="form-title">Add News Entry</h2>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="text" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">Select a category</option>
                    <option value="Events">Events</option>
                    <option value="Volunteer">Volunteer</option>
                    <option value="News">News</option>
                    <option value="Updates">Updates</option>
                    <option value="Announcements">Announcements</option>
                </select>
            </div>

            <div class="form-group">
                <label for="clubs">Club/Society:</label>
                <input type="text" id="clubs" name="clubs" required>
            </div>

            <div class="form-group">
                <input type="submit" name="news" value="Add News">
            </div>
        </form>
    </div>
</body>
</html>