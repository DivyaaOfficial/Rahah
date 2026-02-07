<?php
session_start();
include('header.php');
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - Sistem Pengundian Kelab Olahraga</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        :root {
            --primary: #dc3545;
            --primary-dark: #c82333;
            --primary-light: #ff6b7a;
            --secondary: #28a745;
            --secondary-dark: #218838;
            --accent: #ffc107;
            --light: #ffffff;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #f8f9fa;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.25);
            --border-radius: 15px;
            --transition: all 0.3s ease;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, 
                rgba(0, 0, 0, 0.85) 0%, 
                rgba(220, 53, 69, 0.3) 100%),
                url('gambar/login-bg.jpg?v=<?= time(); ?>') no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Main Container */
        .main-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 600px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        /* Left Side - Branding */
        .brand-section {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 20%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 1;
        }

        .brand-logo i {
            font-size: 50px;
            color: white;
        }

        .brand-text {
            position: relative;
            z-index: 1;
        }

        .brand-text h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .brand-text h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .brand-text p {
            font-size: 14px;
            line-height: 1.6;
            max-width: 350px;
            opacity: 0.8;
            margin-bottom: 30px;
        }

        .features-list {
            margin-top: 30px;
            text-align: left;
            max-width: 350px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .feature-item i {
            color: var(--accent);
            font-size: 16px;
        }

        /* Right Side - Login Form */
        .login-section {
            flex: 1.2;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .form-header p {
            color: var(--gray);
            font-size: 14px;
        }

        /* Form Styles */
        .form-container {
            max-width: 380px;
            margin: 0 auto;
            width: 100%;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }

        .input-group i:first-child {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 16px;
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 15px;
            transition: var(--transition);
            background: var(--light-gray);
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
            background: white;
        }

        .form-input::placeholder {
            color: #adb5bd;
        }

        .password-toggle-btn {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            z-index: 2;
        }

        .password-toggle-btn:hover {
            color: var(--primary);
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(220, 53, 69, 0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .login-btn.loading {
            opacity: 0.8;
            cursor: not-allowed;
        }

        /* Footer Links */
        .form-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e1e5e9;
        }

        .register-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
            margin-bottom: 20px;
            font-size: 14px;
        }

        .register-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(40, 167, 69, 0.4);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            font-size: 14px;
        }

        .back-link:hover {
            color: var(--primary-dark);
            transform: translateX(-5px);
        }

        /* Alerts */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            font-size: 14px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-error {
            background: #fee;
            color: #d00;
            border: 2px solid #fcc;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #efe;
            color: #0a0;
            border: 2px solid #cfc;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
                max-width: 450px;
                min-height: auto;
            }
            
            .brand-section {
                padding: 30px 25px;
                order: 2;
            }
            
            .login-section {
                padding: 40px 25px;
                order: 1;
            }
            
            .brand-logo {
                width: 100px;
                height: 100px;
            }
            
            .brand-logo i {
                font-size: 40px;
            }
            
            .brand-text h1 {
                font-size: 24px;
            }
            
            .brand-text h2 {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .main-wrapper {
                border-radius: 20px;
            }
            
            .brand-section,
            .login-section {
                padding: 25px 20px;
            }
            
            .form-header h1 {
                font-size: 24px;
            }
            
            .login-btn {
                padding: 14px;
                font-size: 15px;
            }
        }

        /* Custom Checkbox for Remember Me */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            color: var(--gray);
            font-size: 13px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Left Branding Section -->
    <div class="brand-section">
        <div class="brand-logo">
            <i class="fas fa-vote-yea"></i>
        </div>
        <div class="brand-text">
            <h1>SISTEM PENGUNDIAN DIGITAL</h1>
            <h2>Kelab Olahraga SMK St. George</h2>
            <p>Platform pengundian dalam talian yang selamat, pantas dan telus untuk pemilihan jawatan kelab.</p>
        </div>
        
        <div class="features-list">
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <span>Sistem keselamatan terkini</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-bolt"></i>
                <span>Proses pengundian pantas</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-line"></i>
                <span>Keputusan masa nyata</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-mobile-alt"></i>
                <span>Mesra semua peranti</span>
            </div>
        </div>
    </div>
    
    <!-- Right Login Form Section -->
    <div class="login-section">
        <div class="form-header">
            <h1>Log Masuk ke Sistem</h1>
            <p>Sila masukkan maklumat akaun anda</p>
        </div>
        
        <div class="form-container">
            <!-- Error/Success Messages -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error" id="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success" id="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($_GET['success']); ?></span>
                </div>
            <?php endif; ?>

            <form action="login-proses.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label class="form-label" for="nokp">
                        <i class="fas fa-id-card" style="margin-right: 8px;"></i>
                        Nombor Kad Pengenalan
                    </label>
                    <div class="input-group">
                        <i class="fas fa-id-card"></i>
                        <input type="text" 
                               id="nokp" 
                               name="nokp" 
                               class="form-input" 
                               placeholder="Contoh: 010203045678" 
                               required
                               autocomplete="username"
                               autofocus>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="form-label" for="katalaluan">
                        <i class="fas fa-key" style="margin-right: 8px;"></i>
                        Kata Laluan
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="katalaluan" 
                               name="katalaluan" 
                               class="form-input" 
                               placeholder="Masukkan kata laluan anda" 
                               required
                               autocomplete="current-password">
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya pada peranti ini</label>
                </div>

                <button type="submit" class="login-btn" id="submitBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    LOG MASUK SEKARANG
                </button>
            </form>

            <div class="form-footer">
                <a href="signup.php" class="register-link">
                    <i class="fas fa-user-plus"></i>
                    Daftar Akaun Baru
                </a>
                <br>
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Laman Utama
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Password Visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('katalaluan');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Auto-hide messages after 5 seconds
    setTimeout(function() {
        const messages = document.querySelectorAll('.alert');
        messages.forEach(function(message) {
            message.style.transition = 'opacity 0.5s ease';
            message.style.opacity = '0';
            setTimeout(() => message.style.display = 'none', 500);
        });
    }, 5000);

    // Form validation and submission
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const nokp = document.getElementById('nokp').value.trim();
        const password = document.getElementById('katalaluan').value.trim();
        const submitBtn = document.getElementById('submitBtn');
        
        // Clear previous errors
        const existingError = document.querySelector('.alert-error:not(#error-message)');
        if (existingError) existingError.remove();
        
        let hasError = false;
        
        if (!nokp) {
            showError('Sila masukkan nombor kad pengenalan anda');
            hasError = true;
        }
        
        if (!password) {
            showError('Sila masukkan kata laluan anda');
            hasError = true;
        }
        
        // Validate NRIC format
        const nokpRegex = /^\d{12}$/;
        if (nokp && !nokpRegex.test(nokp)) {
            showError('No. KP mesti mengandungi 12 digit nombor sahaja');
            hasError = true;
        }
        
        if (hasError) {
            return;
        }
        
        // Add loading state to button
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> SEDANG MEMPROSES...';
        submitBtn.disabled = true;
        
        // Remember me functionality
        const rememberCheckbox = document.getElementById('remember');
        if (rememberCheckbox.checked) {
            localStorage.setItem('remembered_nokp', nokp);
        } else {
            localStorage.removeItem('remembered_nokp');
        }
        
        // Submit the form after validation
        setTimeout(() => {
            this.submit();
        }, 500);
    });

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-error';
        errorDiv.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <span>${message}</span>
        `;
        
        const formContainer = document.querySelector('.form-container');
        const form = document.querySelector('#loginForm');
        formContainer.insertBefore(errorDiv, form);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            errorDiv.style.transition = 'opacity 0.5s ease';
            errorDiv.style.opacity = '0';
            setTimeout(() => errorDiv.remove(), 500);
        }, 5000);
    }

    // Add input focus effects
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });

    // Pre-fill if there's remembered data
    window.addEventListener('load', function() {
        const rememberedNokp = localStorage.getItem('remembered_nokp');
        if (rememberedNokp) {
            document.getElementById('nokp').value = rememberedNokp;
            document.getElementById('remember').checked = true;
        }
    });
</script>

</body>
</html>