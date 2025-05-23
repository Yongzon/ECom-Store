<?php
session_start();
require 'vendor/autoload.php';
include 'helpers/functions.php';

use Aries\MiniFrameworkStore\Models\User;

$user = new User();
$message = ''; // Initialize message to prevent undefined variable notice

if(isset($_POST['submit'])) {
    // Basic validation for empty fields (client-side 'required' helps, but server-side is crucial)
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $message = 'Please enter both email and password.';
    } else {
        $user_info = $user->login([
            'email' => $_POST['email'],
        ]);

        if($user_info && password_verify($_POST['password'], $user_info['password'])) {
            $_SESSION['user'] = $user_info;
            header('Location: my-account.php');
            exit;
        } else {
            $message = 'Invalid email or password.'; // More generic message for security
        }
    }
}

// Redirect if already logged in
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: my-account.php');
    exit;
}

// Include header template
template('header.php');
?>

<div class="d-flex align-items-center justify-content-center min-vh-100 bg-light"> <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4"> <div class="card shadow p-4"> <h1 class="text-center mb-4 text-primary">Login</h1> <?php if (isset($message) && !empty($message)) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo htmlspecialchars($message); // Use htmlspecialchars for security ?>
                        </div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control" id="emailInput" aria-describedby="emailHelp" required autocomplete="email">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="passwordInput" required autocomplete="current-password">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMeCheck">
                            <label class="form-check-label" for="rememberMeCheck">Remember me</label>
                        </div>
                        <div class="d-grid gap-2"> <button type="submit" name="submit" class="btn btn-primary btn-lg">Login</button> </div>
                    </form>
                    <div class="mt-4 text-center">
                        <p>
                            <a href="forgot-password.php" class="text-decoration-none">Forgot password?</a>
                        </p>
                        <p class="mb-0">
                            Don't have an account? <a href="register.php" class="text-decoration-none">Register here.</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>