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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>     
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #7209b7;
            --accent-color: #4cc9f0;
            --text-color: #2b2d42;
            --light-gray: #f8f9fa;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(67, 97, 238, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7ff;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .register-container {
            max-width: 550px;
            margin: 2.5rem auto;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: white;
            position: relative;
            overflow: hidden;
        }
        
        .register-container::before {
            content: '';
            position: absolute;
            top: -5px;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            border-radius: 5px;
        }
        
        .register-container h1 {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 2.2rem;
            color: var(--primary-color);
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
        }
        
        .register-container h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            margin: 0.5rem auto 0;
            border-radius: 2px;
        }
        
        .register-form {
            display: grid;
            gap: 1.5rem;
        }
        
        .register-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
            font-size: 0.95rem;
        }
        
        .register-form .input-group {
            position: relative;
        }
        
        .register-form .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.1rem;
            z-index: 1;
        }
        
        .register-form input,
        .register-form select {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: white;
        }
        
        .register-form input:focus,
        .register-form select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            border-color: var(--primary-color);
            background-color: #fcfcff;
        }
        
        .register-form input::placeholder {
            color: #adb5bd;
        }
        
        .register-form .btn {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            letter-spacing: 0.5px;
        }
        
        .register-form .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .register-form .btn:active {
            transform: translateY(-1px);
        }
        
        .register-container p {
            text-align: center;
            margin-top: 1.8rem;
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .register-container .btn-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }
        
        .register-container .btn-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transition: var(--transition);
        }
        
        .register-container .btn-link:hover {
            color: var(--secondary-color);
        }
        
        .register-container .btn-link:hover::after {
            width: 100%;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .register-container {
                padding: 2rem 1.5rem;
                margin: 1.5rem auto;
            }
        }
        
        .required-field::after {
            content: '*';
            color: #e63946;
            margin-left: 3px;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
            z-index: 1;
        }
        
        .fancy-transition {
            transition: var(--transition);
        }
        
        .fancy-transition:hover {
            transform: translateY(-2px);
        }
    </style>
</head> 
<body>     
    <?php include 'header.php'; ?>      
    <main>         
        <section class="register-container">             
            <h1>Create Account</h1>             
            <form action="register.php" method="POST" class="register-form">
                <div class="form-grid">
                    <div class="input-group fancy-transition">
                        <label for="name" class="required-field">Full Name</label>
                        <div class="icon"><i class="fas fa-user"></i></div>                 
                        <input type="text" id="name" name="name" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="input-group fancy-transition">
                        <label for="roll" class="required-field">Student ID</label>
                        <div class="icon"><i class="fas fa-id-card"></i></div>                 
                        <input type="number" id="roll" name="roll" required placeholder="Enter your student ID">
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="input-group fancy-transition">
                        <label for="dept" class="required-field">Department</label>
                        <div class="icon"><i class="fas fa-graduation-cap"></i></div>                 
                        <select name="dept" id="dept" required>                     
                            <option value="">Select Department</option>                     
                            <option value="CSE">Computer Science & Engineering</option>                     
                            <option value="EEE">Electrical & Electronic Engineering</option>                     
                            <option value="ECO">Economics</option>                     
                            <option value="LLB">Law</option> 
                            <option value="ENG">English</option>
                            <option value="BBA">Business Administration</option>                  
                        </select>
                    </div>
                    
                    <div class="input-group fancy-transition">
                        <label for="batch" class="required-field">Batch</label>
                        <div class="icon"><i class="fas fa-users"></i></div>                 
                        <input type="text" id="batch" name="batch" required placeholder="Enter your batch (e.g. 2022-2026)">
                    </div>
                </div>
                
                <div class="input-group fancy-transition">
                    <label for="email" class="required-field">Email Address</label>
                    <div class="icon"><i class="fas fa-envelope"></i></div>                 
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                </div>
                
                <div class="input-group fancy-transition">
                    <label for="password" class="required-field">Password</label>
                    <div class="icon"><i class="fas fa-lock"></i></div>                 
                    <input type="password" id="password" name="password" required placeholder="Create a strong password">
                    <div class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </div>
                </div>
                
                <button type="submit" name="register" class="btn">Create Account <i class="fas fa-arrow-right ml-2"></i></button>             
            </form>             
            <p>Already have an account? <a href="login.php" class="btn-link">Sign In</a></p>         
        </section>     
    </main>      
    <?php include 'footer.php'; ?>      
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Form validation
        document.querySelector('.register-form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long');
            }
        });
    </script>
</body> 
</html>