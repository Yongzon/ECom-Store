<?php
session_start(); 
include 'helpers/functions.php';
require 'vendor/autoload.php';

use Aries\MiniFrameworkStore\Models\User;
use Carbon\Carbon;

$user = new User();
$message = ''; 
$message_type = ''; 

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

if(isset($_POST['submit'])) {
    $fullName = trim($_POST['full-name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password']; 


    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $message = 'All fields are required.';
        $message_type = 'danger';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $message_type = 'danger';
    } elseif ($password !== $confirmPassword) {
        $message = 'Passwords do not match.';
        $message_type = 'danger';
    } elseif (strlen($password) < 6) { 
        $message = 'Password must be at least 6 characters long.';
        $message_type = 'danger';
    } else {
        $registered = $user->register([
            'name' => $fullName,
            'email' => $email,
            'password' => $password, 
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila')
        ]);

        if($registered) {
            $message = 'You have successfully registered! You may now <a href="login.php" class="alert-link">login</a>.';
            $message_type = 'success';
            $_POST = []; 
        } else {
            $message = 'Registration failed. Please try again or contact support.';
            $message_type = 'danger';
        }
    }
}

template('header.php');
?>

<div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5"> <div class="card shadow p-4">
                    <h1 class="text-center mb-4 text-primary">Register Account</h1>

                    <?php if (!empty($message)) : ?>
                        <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> text-center" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="fullNameInput" class="form-label">Full Name</label>
                            <input name="full-name" type="text" class="form-control" id="fullNameInput" required autocomplete="name" value="<?php echo htmlspecialchars($_POST['full-name'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control" id="emailInput" aria-describedby="emailHelp" required autocomplete="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="passwordInput" required autocomplete="new-password">
                        </div>
                        <div class="mb-4"> <label for="confirmPasswordInput" class="form-label">Confirm Password</label>
                            <input name="confirm-password" type="password" class="form-control" id="confirmPasswordInput" required autocomplete="new-password">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg">Register</button>
                        </div>
                    </form>
                    <div class="mt-4 text-center">
                        <p class="mb-0">
                            Already have an account? <a href="login.php" class="text-decoration-none">Login here.</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>