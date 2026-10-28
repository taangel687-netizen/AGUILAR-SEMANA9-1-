<?php
// config.php - configuración común del laboratorio 09 (PHP)
declare(strict_types=1);

const APP_NAME = 'Lab 09 - PHP';

// Buenas prácticas: no mostrar errores al usuario, registrarlos en el log
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// Cabeceras de seguridad básicas (deben enviarse antes de cualquier salida)
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');

// Sesión con cookie protegida
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Escapa texto antes de imprimirlo en HTML (previene XSS)
function e(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Cabecera HTML reutilizable
function html_inicio(string $titulo): void
{
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . e($titulo) . '</title>';
    echo '<style>body{font-family:Arial,sans-serif;max-width:560px;margin:2rem auto;padding:0 1rem}';
    echo '.error{color:#b00020}.ok{color:#1b5e20}table{border-collapse:collapse}';
    echo 'td,th{border:1px solid #999;padding:.4rem .8rem;text-align:left}</style></head><body>';
    echo '<h1>' . e(APP_NAME) . '</h1>';
}

function html_fin(): void
{
    echo '</body></html>';
}
