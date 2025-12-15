<?php
session_start();
require_once("config.php");

// Make sure no output occurs before this point

$error_message = '';

if (isset($_POST['btn-login'])) {
    // Retrieve and trim input values
    $credential = trim($_POST['credential']); // Used for both email and contact
    $password = trim($_POST['password']);

    // Use a prepared statement for security
    $sql = "SELECT a_id, a_email, a_pass FROM admin WHERE a_email = ? OR a_cont = ?";
    if ($stmt = $DBcon->prepare($sql)) {
        $stmt->bind_param("ss", $credential, $credential);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['a_pass'])) {
                $_SESSION['login_admin'] = $row['a_id'];
                // Redirect before any HTML output
                header("Location: adminhome.php");
                exit();
            } else {
                $error_message = "Invalid credentials.";
            }
        } else {
            $error_message = "Invalid credentials.";
        }
        $stmt->close();
    } else {
        die("SQL error: " . $DBcon->error);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRQuestLogin - Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(45deg, #ff6b6b, #ff8e53);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .auth-container {
            position: relative;
            z-index: 1;
            backdrop-filter: blur(16px);
            background: var(--glass-bg);
            border-radius: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .brand-section {
            background: var(--secondary-gradient);
            padding: 4rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 6s infinite;
        }

        .brand-icon {
            width: 120px;
            height: 120px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .brand-icon:hover {
            transform: rotate(15deg) scale(1.1);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 1rem;
            padding: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .password-toggle {
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #475569;
        }

        .btn-magic {
            background: var(--secondary-gradient);
            border: none;
            padding: 1rem 2rem;
            border-radius: 1rem;
            color: white;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .btn-magic::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transform: rotate(45deg);
            animation: shine 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.1);
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .error-toast {
            position: fixed;
            top: 2rem;
            right: 2rem;
            backdrop-filter: blur(10px);
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border-radius: 0.5rem;
            padding: 1rem 2rem;
            transform: translateY(-200%);
            animation: slideIn 0.5s forwards;
        }

        @keyframes slideIn {
            to {
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="particles">
        <!-- Particle animation container -->
    </div>

    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="auth-container">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="brand-section d-flex flex-column align-items-center justify-content-center">
                                <svg class="brand-icon mb-4" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L3 7L12 12L21 7L12 2Z" fill="currentColor" />
                                    <path d="M3 7L12 12V22L3 17V7Z" fill="currentColor" />
                                    <path d="M21 7L12 12V22L21 17V7Z" fill="currentColor" />
                                </svg>
                                <h2 class="display-5 fw-bold mb-3">QRQuestLogin</h2>
                                <p class="text-center px-4">
                                    Advanced Administration Portal<br>
                                    Secure Access Interface
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <?php if ($error_message): ?>
                                    <div class="error-toast">
                                        <?php echo htmlspecialchars($error_message); ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" id="login-form" class="needs-validation" novalidate>
                                    <div class="mb-4">
                                        <label class="form-label text-muted mb-2">Administrative Credentials</label>
                                        <input type="text" class="form-control shadow-sm" name="credential" placeholder="admin@qrquest.com" required autofocus>
                                        <div class="invalid-feedback">
                                            Please provide valid credentials
                                        </div>
                                    </div>

                                    <div class="mb-4 position-relative">
                                        <input type="password" class="form-control shadow-sm" name="password" id="password" placeholder="•••••••••••" required>
                                        <span class="password-toggle position-absolute">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <div class="invalid-feedback">
                                            Please enter your access code
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" name="btn-login" class="btn-magic">
                                            <i class="fas fa-lock-open me-2"></i>
                                            Authenticate Session
                                        </button>
                                    </div>

                                    <div class="text-center mt-4">
                                        <p class="text-muted mb-2">Advanced Authentication</p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <button type="button" class="btn btn-outline-light rounded-pill">
                                                <i class="fab fa-google"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-light rounded-pill">
                                                <i class="fas fa-fingerprint"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-light rounded-pill">
                                                <i class="fas fa-mobile-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle functionality
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Form validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Particle animation
        function createParticles() {
            const container = document.querySelector('.particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute;
                    width: 8px;
                    height: 8px;
                    background: rgba(255,255,255,0.3);
                    border-radius: 50%;
                    top: ${Math.random() * 100}%;
                    left: ${Math.random() * 100}%;
                    animation: float ${5 + Math.random() * 10}s infinite linear;
                `;
                container.appendChild(particle);
            }
        }
        createParticles();
    </script>
</body>

</html>