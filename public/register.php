<?php
require_once dirname(__DIR__) . '/app/auth.php';
require_once dirname(__DIR__) . '/app/config.php';

redirect_if_logged_in();

$error = '';
$name = '';
$businessName = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $businessName = trim($_POST['business_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($name === '' || $businessName === '' || $email === '' || $password === '') {
        $error = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email belum valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO users (name, business_name, email, password_hash) VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([
                $name,
                $businessName,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
            ]);

            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int) $pdo->lastInsertId(),
                'name' => $name,
                'business_name' => $businessName,
                'email' => $email,
            ];

            header('Location: dashboard.php');
            exit;
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                $error = 'Email sudah terdaftar. Silakan login.';
            } else {
                $error = 'Pendaftaran gagal. Coba beberapa saat lagi.';
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar - SahabatUMKM AI</title>
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
        <h1>Daftarkan usaha dan mulai pakai asisten AI.</h1>
        <p>
          Akun menyimpan identitas UMKM agar dashboard terasa personal untuk pemilik usaha.
        </p>
      </section>

      <section class="auth-card" aria-label="Form daftar">
        <p class="eyebrow">Buat akun</p>
        <h2>Daftar SahabatUMKM AI</h2>

        <?php if ($error !== ''): ?>
          <div class="auth-alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" class="auth-form">
          <label>
            Nama pemilik
            <input name="name" type="text" value="<?= e($name) ?>" required />
          </label>
          <label>
            Nama UMKM
            <input name="business_name" type="text" value="<?= e($businessName) ?>" required />
          </label>
          <label>
            Email
            <input name="email" type="email" value="<?= e($email) ?>" required />
          </label>
          <label>
            Password
            <input name="password" type="password" minlength="6" required />
          </label>
          <label>
            Konfirmasi password
            <input name="confirm_password" type="password" minlength="6" required />
          </label>
          <button class="primary-button" type="submit">Daftar</button>
        </form>

        <p class="auth-switch">
          Sudah punya akun? <a href="login.php">Login</a>
        </p>
      </section>
    </main>
  </body>
</html>
