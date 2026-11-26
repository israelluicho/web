<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('America/Lima');

define('DB_HOST', 'localhost');
define('DB_NAME', 'biblioteca_db');
define('DB_USER', 'root');
define('DB_PASS', '');

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function require_login(): void {
    if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
}
function flash(string $message, string $type='success'): void { $_SESSION['flash']=['message'=>$message,'type'=>$type]; }
function show_flash(): void {
    if (!empty($_SESSION['flash'])) {
        $f=$_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="alert alert-'.e($f['type']).' alert-dismissible fade show">'.e($f['message']).'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}
function csrf_field(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));
    return '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">';
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Solicitud no válida. Recargue la página.');
    }
}
