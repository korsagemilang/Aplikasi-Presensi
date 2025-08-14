<?php
// file: login.php
session_start();
require_once 'includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['peran'] = $user['peran'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        
        echo json_encode(['success' => true]);
        exit; // Tambahkan ini untuk menghentikan skrip setelah output JSON
    } else {
        echo json_encode(['success' => false, 'message' => 'Username atau password salah!']);
        exit; // Tambahkan ini juga
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SD NEGERI SUKOKERTO 01</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .login-card { backdrop-filter: blur(20px); background: rgba(255, 255, 255, 0.95); border: 1px solid rgba(255, 255, 255, 0.2); }
        .input-focus { transition: all 0.3s ease; }
        .input-focus:focus { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15); }
        .btn-login { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: all 0.3s ease; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3); }
        .animate-fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .floating-shapes { position: absolute; width: 100%; height: 100%; overflow: hidden; z-index: 0; }
        .shape { position: absolute; border-radius: 50%; background: rgba(255, 255, 255, 0.1); animation: float 6s ease-in-out infinite; }
        .shape:nth-child(1) { width: 80px; height: 80px; top: 20%; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 120px; height: 120px; top: 60%; right: 10%; animation-delay: 2s; }
        .shape:nth-child(3) { width: 60px; height: 60px; bottom: 20%; left: 20%; animation-delay: 4s; }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(180deg); } }
        .error-shake { animation: shake 0.5s ease-in-out; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4 relative">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-card w-full max-w-md rounded-2xl shadow-2xl p-8 animate-fade-in relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <img src="logo.png" alt="Logo Sekolah" class="w-10 h-10 object-contain">
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Login Sistem Informasi Presensi SD NEGERI SUKOKERTO 01</h2>
            <p class="text-gray-600">Silakan masuk untuk melanjutkan</p>
            <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </div>

        <div id="error-message" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 error-shake">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span id="error-text"></span>
            </div>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        required
                        class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Masukkan username Anda"
                    >
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="input-focus block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Masukkan password Anda"
                    >
                    <button 
                        type="button" 
                        id="togglePassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    >
                        <svg id="eyeIcon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <button 
                type="submit" 
                id="loginBtn"
                class="btn-login w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
            >
                <span id="loginText">Masuk</span>
                <svg id="loadingIcon" class="hidden animate-spin -mr-1 ml-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const loginText = document.getElementById('loginText');
        const loadingIcon = document.getElementById('loadingIcon');
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');

        // Toggle password visibility
        if(togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>`;
                } else {
                    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
                }
            });
        }

        // Form submission with loading state
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // === TAMPILKAN LOADING STATE SEBELUM FETCH ===
            loginBtn.disabled = true;
            loginText.textContent = 'Memuat...';
            loadingIcon.classList.remove('hidden');
            errorMessage.classList.add('hidden');

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loginText.textContent = 'Berhasil! Mengalihkan...';
                    window.location.href = 'dashboard.php';
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(() => {
                // === KEMBALIKAN TOMBOL KE NORMAL SETELAH SELESAI ===
                resetForm();
            });
        });

        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
            errorMessage.classList.add('error-shake');
            
            setTimeout(() => {
                errorMessage.classList.remove('error-shake');
            }, 500);
        }

        function resetForm() {
            loginBtn.disabled = false;
            loginText.textContent = 'Masuk';
            loadingIcon.classList.add('hidden');
        }

        // Input focus effects
        const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-purple-500');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-purple-500');
            });
        });

        // Auto-hide error message when typing
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (errorMessage && !errorMessage.classList.contains('hidden')) {
                    errorMessage.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>