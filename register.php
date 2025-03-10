<?php
include("connection.php");
if(isset($_POST['register']))
{
    $roll=$_POST['roll'];
	$name=$_POST['name'];
    $dept=$_POST['dept'];
	$batch=$_POST['batch'];
	$email=$_POST['email'];
	$password=$_POST['password'];

	
	$query="insert into users values('$roll','$name','$dept','$batch','$email','$password')";
	if(mysqli_query($con,$query))
	{
		echo "Successfully inserted!";
        header("Location:login.php");

    }
	else
	{
		echo "error!".mysqli_error($con);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CCCPUC</title>
    <link rel="stylesheet" href="./CSS/login.css">
    <link rel="stylesheet" href="./CSS/index.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="register-container">
            <h1>Register</h1>
            <form action="register.php" method="POST" class="register-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="roll">Student ID:</label>
                <input type="number" id="roll" name="roll" required>

                <label for="dept">Department:</label>
                <select name="dept" id="dept">
                    <option value="">Select Anyone</option>
                    <option value="CSE">CSE</option>
                    <option value="EEE">EEE</option>
                    <option value="ECO">ECO</option>
                    <option value="LLB">LAW</option>
                </select>

                <label for="batch">Batch:</label>
                <input type="text" id="batch" name="batch" required>


                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="register" class="btn">Register</button>
            </form>
            <p>Already have an account? <a href="login.php" class="btn-link">Login</a></p>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
