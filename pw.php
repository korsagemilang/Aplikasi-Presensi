<? // Password dalam bentuk teks biasa
$password_plain = 'Ss20523318@';

// Hash password
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Output hash
echo $password_hashed; 
// Contoh output: $2y$10$tJ08fWc5v8gV2d1p5k6...