<?php
require_once dirname(__DIR__) . '/app/auth.php';
require_once dirname(__DIR__) . '/app/config.php';

redirect_if_logged_in();

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Email dan password wajib diisi.';
    } else {
        $stmt = $pdo->prepare('SELECT id, name, business_name, email, password_hash FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int) $user['id'],
                'name' => $user['name'],
                'business_name' => $user['business_name'],
                'email' => $user['email'],
            ];

            header('Location: dashboard.php');
            exit;
        }

        $error = 'Email atau password tidak sesuai.';
    }
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SahabatUMKM AI</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
  </head>
  <body class="auth-page">
    <main class="auth-shell">
      <section class="auth-hero">
        <div class="brand-lockup">
          <div class="brand-mark" aria-hidden="true">S</div>
          <div>
            <p class="brand-name">SahabatUMKM AI</p>
            <p class="brand-tagline">Asisten harian pelaku usaha</p>
          </div>
        </div>
        <h1>Masuk dan lanjutkan kerja digital UMKM kamu.</h1>
        <p>
          Buat konten, catat transaksi, siapkan balasan pelanggan, dan baca insight penjualan dari satu dashboard.
        </p>
      </section>

      <section class="auth-card" aria-label="Form login">
        <p class="eyebrow">Masuk akun</p>
        <h2>Selamat datang kembali</h2>

        <?php if ($error !== ''): ?>
          <div class="auth-alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" class="auth-form">
          <label>
            Email
            <input name="email" type="email" value="<?= e($email) ?>" required />
          </label>
          <label>
            Password
            <input name="password" type="password" required />
          </label>
          <button class="primary-button" type="submit">Login</button>
        </form>

        <p class="auth-switch">
          Belum punya akun? <a href="register.php">Daftar sekarang</a>
        </p>
      </section>
    </main>
  </body>
</html>
