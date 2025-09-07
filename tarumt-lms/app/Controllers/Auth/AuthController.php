<?php

class AuthController {
    
    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/{$view}.php";
    }
    
    private function redirect($path) {
        header("Location: {$path}");
        exit;
    }
    
    private function isAuthenticated() {
        return isset($_SESSION['user']);
    }
    
    public function showWelcome() {
        $this->render('welcome', [
            'title' => 'Welcome to TARUMT LMS',
            'pageTitle' => 'Welcome to TARUMT Learning Management System',
            'pageSubtitle' => 'Empowering education through innovative learning solutions'
        ]);
    }
    
    public function showLogin() {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/login', [
            'title' => 'Sign In - TARUMT LMS',
            'pageTitle' => 'Welcome back',
            'pageSubtitle' => 'Sign in to your account to continue your learning journey'
        ]);
    }
    
    public function showRegister() {
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/register', [
            'title' => 'Create Account - TARUMT LMS',
            'pageTitle' => 'Create your account',
            'pageSubtitle' => 'Join thousands of learners at TARUMT'
        ]);
    }
    
    public function showForgotPassword() {
        $this->render('auth/forgot-password', [
            'title' => 'Reset Password - TARUMT LMS',
            'pageTitle' => 'Forgot your password?',
            'pageSubtitle' => 'No worries, we\'ll send you reset instructions'
        ]);
    }
    
    public function showResetPassword() {
        $token = $_GET['token'] ?? '';
        if (!$token) {
            $_SESSION['error'] = 'Invalid reset token';
            $this->redirect('/forgot-password');
        }
        
        $this->render('auth/reset-password', [
            'title' => 'Reset Password - TARUMT LMS',
            'pageTitle' => 'Reset your password',
            'pageSubtitle' => 'Enter your new password below',
            'token' => $token
        ]);
    }
    
    public function showVerifyEmail() {
        $this->render('auth/verify-email', [
            'title' => 'Verify Email - TARUMT LMS',
            'pageTitle' => 'Check your email',
            'pageSubtitle' => 'We sent a verification link to your email address'
        ]);
    }
    
    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);
        
        // Dummy authentication
        $users = [
            'student@tarumt.edu' => [
                'id' => 1,
                'name' => 'John Doe',
                'role' => 'student',
                'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=000000&color=ffffff'
            ],
            'instructor@tarumt.edu' => [
                'id' => 2,
                'name' => 'Dr. Jane Smith',
                'role' => 'instructor',
                'avatar' => 'https://ui-avatars.com/api/?name=Jane+Smith&background=000000&color=ffffff'
            ],
            'admin@tarumt.edu' => [
                'id' => 3,
                'name' => 'Admin User',
                'role' => 'admin',
                'avatar' => 'https://ui-avatars.com/api/?name=Admin+User&background=000000&color=ffffff'
            ]
        ];
        
        if (isset($users[$email]) && $password === 'password') {
            $_SESSION['user'] = [
                'id' => $users[$email]['id'],
                'name' => $users[$email]['name'],
                'email' => $email,
                'role' => $users[$email]['role'],
                'avatar' => $users[$email]['avatar'],
                'verified' => true
            ];
            
            $_SESSION['success'] = 'Welcome back, ' . $users[$email]['name'] . '!';
            
            // Redirect based on role - for now all go to dashboard (coming soon page)
            $this->redirect('/dashboard');
        } else {
            $_SESSION['error'] = 'Invalid email or password. Please try again.';
            $this->redirect('/login');
        }
    }
    
    public function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }
        
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'student';
        $terms = isset($_POST['terms']);
        
        // Validation
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'All fields are required';
            $this->redirect('/register');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Please enter a valid email address';
            $this->redirect('/register');
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            $this->redirect('/register');
        }
        
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters long';
            $this->redirect('/register');
        }
        
        if (!$terms) {
            $_SESSION['error'] = 'You must agree to the Terms of Service';
            $this->redirect('/register');
        }
        
        // Dummy registration success
        $_SESSION['user'] = [
            'id' => rand(100, 999),
            'name' => $firstName . ' ' . $lastName,
            'email' => $email,
            'role' => $role,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($firstName . '+' . $lastName) . '&background=000000&color=ffffff',
            'verified' => false
        ];
        
        $_SESSION['success'] = 'Account created successfully! Please check your email to verify your account.';
        $this->redirect('/verify-email');
    }
    
    public function handleForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/forgot-password');
        }
        
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Please enter a valid email address';
            $this->redirect('/forgot-password');
        }
        
        // Dummy success message
        $_SESSION['success'] = 'Password reset instructions have been sent to your email address.';
        $this->redirect('/login');
    }
    
    public function handleResetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/forgot-password');
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            $this->redirect('/reset-password?token=' . urlencode($token));
        }
        
        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters long';
            $this->redirect('/reset-password?token=' . urlencode($token));
        }
        
        // Dummy success
        $_SESSION['success'] = 'Your password has been reset successfully. You can now sign in with your new password.';
        $this->redirect('/login');
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
    
    public function showTerms() {
        $this->render('legal/terms', [
            'title' => 'Terms of Service - TARUMT LMS',
            'pageTitle' => 'Terms of Service',
            'pageSubtitle' => 'Please read these terms carefully before using our services'
        ]);
    }
    
    public function showPrivacy() {
        $this->render('legal/privacy', [
            'title' => 'Privacy Policy - TARUMT LMS',
            'pageTitle' => 'Privacy Policy',
            'pageSubtitle' => 'Learn how we collect, use, and protect your information'
        ]);
    }
}