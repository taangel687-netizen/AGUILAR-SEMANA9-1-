<?php
// info.php - demostración de $_GET y de las cabeceras de la petición
declare(strict_types=1);
require __DIR__ . '/config.php';

html_inicio('Petición GET');
?>
<h2>Datos de la petición</h2>
<p>Método: <strong><?= e($_SERVER['REQUEST_METHOD']) ?></strong></p>
<h3>Parámetros $_GET</h3>
<table>
<?php foreach ($_GET as $clave => $valor): ?>
  <tr><th><?= e((string) $clave) ?></th><td><?= e(is_array($valor) ? 'array' : (string) $valor) ?></td></tr>
<?php endforeach; ?>
<?php if ($_GET === []): ?>
  <tr><td>No se enviaron parámetros. Pruebe: info.php?lang=es&amp;modo=demo</td></tr>
<?php endif; ?>
</table>
<h3>Cabeceras recibidas</h3>
<table>
<?php foreach (getallheaders() as $clave => $valor): ?>
  <tr><th><?= e($clave) ?></th><td><?= e($valor) ?></td></tr>
<?php endforeach; ?>
</table>
<p><a href="index.html">Volver</a></p>
<?php html_fin(); ?>
