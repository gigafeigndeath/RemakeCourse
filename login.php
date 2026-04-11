<?php
require_once __DIR__ . '/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ====================== ВХОД ======================
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $email = trim($_POST['email']);
        $pass  = $_POST['password'];

        $stmt = $pdo->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];

            header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'user.php'));
            exit;
        } else {
            $error = 'Неверный email или пароль';
        }
    }

    // ====================== РЕГИСТРАЦИЯ ======================
    elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        $full_name = trim($_POST['full_name']);
        $email     = trim($_POST['email']);
        $password  = $_POST['password'];
        $class     = trim($_POST['class'] ?? '');

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Этот email уже зарегистрирован';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, class, role) 
                                   VALUES (?, ?, ?, ?, 'user')");
            $stmt->execute([$full_name, $email, $hash, $class]);

            $newId = $pdo->lastInsertId();

            $_SESSION['user_id']   = $newId;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role']      = 'user';

            header('Location: user.php');
            exit;
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container" style="max-width:480px; padding:120px 20px 80px;">
    <h1 style="text-align:center; margin-bottom:40px;">Вход / Регистрация</h1>

    <?php if ($error): ?>
        <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:12px; margin-bottom:20px; text-align:center;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Табы -->
    <div style="display:flex; margin-bottom:30px; border-bottom:2px solid #e2e8f0;">
        <button onclick="showTab(0)" id="tabLogin" 
                style="flex:1; padding:15px; font-weight:600; background:none; border:none; border-bottom:3px solid var(--emerald); color:var(--emerald);">Вход</button>
        <button onclick="showTab(1)" id="tabRegister" 
                style="flex:1; padding:15px; font-weight:600; background:none; border:none;">Регистрация</button>
    </div>

    <!-- Форма входа -->
    <form id="loginForm" method="POST">
        <input type="hidden" name="action" value="login">
        <input type="email" name="email" placeholder="Email" required 
               style="width:100%; padding:16px; margin-bottom:15px; border:1px solid #cbd5e1; border-radius:9999px; font-size:1.1rem;">
        <input type="password" name="password" placeholder="Пароль" required 
               style="width:100%; padding:16px; margin-bottom:25px; border:1px solid #cbd5e1; border-radius:9999px; font-size:1.1rem;">
        <button type="submit" 
                style="width:100%; padding:16px; background:var(--emerald); color:white; border:none; border-radius:9999px; font-size:1.2rem; cursor:pointer;">
            Войти
        </button>
    </form>

    <!-- Форма регистрации (скрыта по умолчанию) -->
    <form id="registerForm" method="POST" style="display:none;">
        <input type="hidden" name="action" value="register">
        <input type="text" name="full_name" placeholder="ФИО ребёнка" required 
               style="width:100%; padding:16px; margin-bottom:15px; border:1px solid #cbd5e1; border-radius:9999px;">
        <input type="email" name="email" placeholder="Email" required 
               style="width:100%; padding:16px; margin-bottom:15px; border:1px solid #cbd5e1; border-radius:9999px;">
        <input type="text" name="class" placeholder="Класс (например 7А)" 
               style="width:100%; padding:16px; margin-bottom:15px; border:1px solid #cbd5e1; border-radius:9999px;">
        <input type="password" name="password" placeholder="Придумайте пароль" required minlength="6"
               style="width:100%; padding:16px; margin-bottom:25px; border:1px solid #cbd5e1; border-radius:9999px;">
        <button type="submit" 
                style="width:100%; padding:16px; background:var(--emerald); color:white; border:none; border-radius:9999px; font-size:1.2rem; cursor:pointer;">
            Создать аккаунт
        </button>
    </form>
</div>

<script>
function showTab(n) {
    document.getElementById('loginForm').style.display = n === 0 ? 'block' : 'none';
    document.getElementById('registerForm').style.display = n === 1 ? 'block' : 'none';
    document.getElementById('tabLogin').style.borderBottom = n === 0 ? '3px solid var(--emerald)' : 'none';
    document.getElementById('tabRegister').style.borderBottom = n === 1 ? '3px solid var(--emerald)' : 'none';
}
</script>

<?php include 'includes/footer.php'; ?>
