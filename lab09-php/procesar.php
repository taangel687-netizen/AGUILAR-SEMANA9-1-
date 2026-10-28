<?php
// procesar.php - recibe el formulario, valida y redirige (patrón Post/Redirect/Get)
declare(strict_types=1);
require __DIR__ . '/config.php';

// 1) Solo se acepta POST; cualquier otro método devuelve 405
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    html_inicio('405 - Método no permitido');
    echo '<h2 class="error">405 Method Not Allowed</h2>';
    echo '<p>Este recurso solo acepta POST. <a href="index.html">Volver al formulario</a></p>';
    html_fin();
    exit;
}

// 2) Lectura y validación con filter_input() (sin register_globals)
$nombre  = trim((string) filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW));
$email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$edad    = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 16, 'max_range' => 100],
]);
$mensaje = trim((string) filter_input(INPUT_POST, 'mensaje', FILTER_UNSAFE_RAW));

$errores = [];
if ($nombre === '' || mb_strlen($nombre) > 60) {
    $errores[] = 'El nombre es obligatorio (máximo 60 caracteres).';
}
if ($email === false || $email === null) {
    $errores[] = 'El correo electrónico no es válido.';
}
if ($edad === false || $edad === null) {
    $errores[] = 'La edad debe ser un número entero entre 16 y 100.';
}
if (mb_strlen($mensaje) > 300) {
    $errores[] = 'El mensaje no puede superar los 300 caracteres.';
}

// 3) Si hay errores: 400 Bad Request y se muestran los mensajes
if ($errores !== []) {
    http_response_code(400);
    html_inicio('Error de validación');
    echo '<h2 class="error">Datos no válidos (400 Bad Request)</h2><ul>';
    foreach ($errores as $error) {
        echo '<li class="error">' . e($error) . '</li>';
    }
    echo '</ul><p><a href="index.html">Volver al formulario</a></p>';
    html_fin();
    exit;
}

// 4) Todo correcto: se guarda en sesión y se redirige (302) a la vista
$_SESSION['ultimo'] = [
    'nombre'  => $nombre,
    'email'   => $email,
    'edad'    => $edad,
    'mensaje' => $mensaje,
    'fecha'   => date('Y-m-d H:i:s'),
];
$_SESSION['envios'] = ($_SESSION['envios'] ?? 0) + 1;

header('Location: resultado.php', true, 302);
exit;
