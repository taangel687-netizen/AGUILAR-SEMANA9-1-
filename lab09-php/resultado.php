<?php
// resultado.php - "vista" del mini-MVC: solo muestra lo que el controlador guardó
declare(strict_types=1);
require __DIR__ . '/config.php';

if (!isset($_SESSION['ultimo'])) {
    header('Location: index.html', true, 302);
    exit;
}
$d = $_SESSION['ultimo'];

html_inicio('Resultado');
?>
<h2 class="ok">Formulario recibido correctamente</h2>
<table>
  <tr><th>Nombre</th><td><?= e($d['nombre']) ?></td></tr>
  <tr><th>Correo</th><td><?= e($d['email']) ?></td></tr>
  <tr><th>Edad</th><td><?= e((string) $d['edad']) ?></td></tr>
  <tr><th>Mensaje</th><td><?= e($d['mensaje']) ?></td></tr>
  <tr><th>Fecha</th><td><?= e($d['fecha']) ?></td></tr>
</table>
<p>Envíos en esta sesión: <strong><?= (int) $_SESSION['envios'] ?></strong></p>
<p>Método: <?= e($_SERVER['REQUEST_METHOD']) ?> |
   PHP <?= e(PHP_VERSION) ?> |
   ID de sesión: <?= e(substr(session_id(), 0, 8)) ?>…</p>
<p><a href="index.html">Enviar otro formulario</a></p>
<?php html_fin(); ?>
