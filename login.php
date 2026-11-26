<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $stmt=db()->prepare('SELECT id,nombre,usuario,password_hash,rol FROM usuarios WHERE usuario=? AND activo=1');
    $stmt->execute([trim($_POST['usuario'] ?? '')]); $u=$stmt->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
        session_regenerate_id(true);
        unset($u['password_hash']); $_SESSION['user']=$u;
        header('Location: index.php'); exit;
    }
    $error='Usuario o contraseña incorrectos.';
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Acceso | Biblioteca</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="assets/style.css" rel="stylesheet"></head>
<body class="login-page"><div class="login-card shadow"><div class="text-center mb-4"><div class="brand-icon">📚</div><h3 class="fw-bold mt-2">Biblioteca Central</h3><p class="text-muted">Sistema de gestión bibliotecaria</p></div>
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<form method="post"><?=csrf_field()?><div class="mb-3"><label class="form-label">Usuario</label><input class="form-control form-control-lg" name="usuario" required autofocus></div><div class="mb-3"><label class="form-label">Contraseña</label><input type="password" class="form-control form-control-lg" name="password" required></div><button class="btn btn-primary btn-lg w-100">Ingresar al sistema</button></form>
<div class="small text-muted mt-4 text-center">Acceso de demostración: admin / Admin123*</div></div></body></html>
