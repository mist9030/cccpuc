<?php
session_start();
if (isset($_SESSION['roll'])) {
    header("Location:index.php");
    exit();
}
include("connection.php");
if(isset($_POST['login']))
{
    $roll=$_POST['roll'];
    $password=$_POST['password'];

    // Secure version would use password_verify() with the stored hash
    $sql="select roll,password from users where roll='$roll'";
    $result=mysqli_query($con,$sql);
    
    if(mysqli_num_rows($result)==1)
    {
        $row = mysqli_fetch_assoc($result);
        // If using hashed passwords (as in the enhanced register page)
        // if(password_verify($password, $row['password'])) {
        if($password == $row['password']) {  // For compatibility with original code
            $_SESSION['roll']=$roll;
            header("Location:index.php");
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    }
    else
    {
        $error_message = "Student ID not found. Please check your ID or register.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CCCPUC</title>
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
        
        .login-container {
            max-width: 450px;
            margin: 4rem auto;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: white;
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: -5px;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            border-radius: 5px;
        }
        
        .login-container h1 {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 2.2rem;
            color: var(--primary-color);
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
        }
        
        .login-container h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            margin: 0.5rem auto 0;
            border-radius: 2px;
        }
        
        .login-form {
            display: grid;
            gap: 1.5rem;
        }
        
        .login-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
            font-size: 0.95rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.1rem;
            z-index: 1;
        }
        
        .login-form input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: white;
        }
        
        .login-form input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            border-color: var(--primary-color);
            background-color: #fcfcff;
        }
        
        .login-form input::placeholder {
            color: #adb5bd;
        }
        
        .login-form .btn {
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
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            letter-spacing: 0.5px;
        }
        
        .login-form .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .login-form .btn:active {
            transform: translateY(-1px);
        }
        
        .login-container p {
            text-align: center;
            margin-top: 1.8rem;
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .login-container .btn-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }
        
        .login-container .btn-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transition: var(--transition);
        }
        
        .login-container .btn-link:hover {
            color: var(--secondary-color);
        }
        
        .login-container .btn-link:hover::after {
            width: 100%;
        }
        
        .fancy-transition {
            transition: var(--transition);
        }
        
        .fancy-transition:hover {
            transform: translateY(-2px);
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
        
        .error-message {
            background-color: #fff8f8;
            border-left: 4px solid #e63946;
            color: #e63946;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 5px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }
        
        .forgot-password a {
            color: #6c757d;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .forgot-password a:hover {
            color: var(--primary-color);
        }
        
        .login-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .login-divider::before,
        .login-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #e9ecef;
        }
        
        .login-divider::before {
            margin-right: 1rem;
        }
        
        .login-divider::after {
            margin-left: 1rem;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #f8f9fa;
            transition: var(--transition);
            color: #6c757d;
            border: 1px solid #e9ecef;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .google-btn:hover {
            color: #DB4437;
        }
        
        .facebook-btn:hover {
            color: #4267B2;
        }
        
        .twitter-btn:hover {
            color: #1DA1F2;
        }
        
        @media (max-width: 640px) {
            .login-container {
                padding: 2rem 1.5rem;
                margin: 2rem auto;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="login-container">
            <h1>Welcome Back</h1>
            
            <?php if(isset($error_message)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST" class="login-form">
                <div class="input-group fancy-transition">
                    <label for="roll">Student ID</label>
                    <div class="icon"><i class="fas fa-id-card"></i></div>
                    <input type="number" id="roll" name="roll" required placeholder="Enter your student ID">
                </div>
                
                <div class="input-group fancy-transition">
                    <label for="password">Password</label>
                    <div class="icon"><i class="fas fa-lock"></i></div>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <div class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </div>
                </div>
                
                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" name="login" class="btn">Sign In <i class="fas fa-sign-in-alt ml-2"></i></button>
            </form>
            
            <div class="login-divider">Or continue with</div>
            
            <div class="social-login">
                <a href="#" class="social-btn google-btn"><i class="fab fa-google"></i></a>
                <a href="#" class="social-btn facebook-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn twitter-btn"><i class="fab fa-twitter"></i></a>
            </div>
            
            <p>Don't have an account? <a href="register.php" class="btn-link">Create Account</a></p>
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
        
        // Auto-hide error message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = document.querySelector('.error-message');
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.opacity = '0';
                    errorMessage.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() {
                        errorMessage.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>