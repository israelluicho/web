<?php
require 'config.php'; require_login();
$pageTitle='Dashboard';
$pdo=db();
$stats=[
 'libros'=>$pdo->query('SELECT COUNT(*) FROM libros')->fetchColumn(),
 'lectores'=>$pdo->query('SELECT COUNT(*) FROM lectores')->fetchColumn(),
 'prestados'=>$pdo->query("SELECT COUNT(*) FROM prestamos WHERE estado='Prestado'")->fetchColumn(),
 'vencidos'=>$pdo->query("SELECT COUNT(*) FROM prestamos WHERE estado='Prestado' AND fecha_devolucion < CURDATE()")->fetchColumn()
];
$recent=$pdo->query("SELECT p.id,l.titulo,le.nombre lector,p.fecha_prestamo,p.fecha_devolucion,p.estado FROM prestamos p JOIN libros l ON l.id=p.libro_id JOIN lectores le ON le.id=p.lector_id ORDER BY p.id DESC LIMIT 6")->fetchAll();
require 'partials/header.php';
?>
<div class="row g-3 mb-4">
<?php foreach([['Libros registrados',$stats['libros'],'bi-book','primary'],['Lectores',$stats['lectores'],'bi-people','success'],['Préstamos activos',$stats['prestados'],'bi-journal-arrow-up','warning'],['Devoluciones vencidas',$stats['vencidos'],'bi-alarm','danger']] as $s): ?>
<div class="col-12 col-sm-6 col-xl-3"><div class="card stat-card border-0 shadow-sm"><div class="card-body d-flex align-items-center justify-content-between"><div><div class="text-muted"><?=$s[0]?></div><div class="display-6 fw-bold"><?=$s[1]?></div></div><div class="stat-icon text-<?=$s[3]?>"><i class="bi <?=$s[2]?>"></i></div></div></div></div>
<?php endforeach; ?></div>
<div class="row g-4"><div class="col-lg-8"><div class="card border-0 shadow-sm"><div class="card-header bg-white py-3 fw-semibold">Préstamos recientes</div><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Libro</th><th>Lector</th><th>Préstamo</th><th>Devolución</th><th>Estado</th></tr></thead><tbody>
<?php foreach($recent as $r): ?><tr><td><?=e($r['titulo'])?></td><td><?=e($r['lector'])?></td><td><?=e($r['fecha_prestamo'])?></td><td><?=e($r['fecha_devolucion'])?></td><td><span class="badge text-bg-<?=$r['estado']==='Devuelto'?'success':'warning'?>"><?=e($r['estado'])?></span></td></tr><?php endforeach; ?>
<?php if(!$recent): ?><tr><td colspan="5" class="text-center text-muted py-4">No hay préstamos registrados.</td></tr><?php endif; ?></tbody></table></div></div></div>
<div class="col-lg-4"><div class="card border-0 shadow-sm"><div class="card-header bg-white py-3 fw-semibold">Accesos rápidos</div><div class="card-body d-grid gap-2"><a class="btn btn-outline-primary text-start" href="libros.php"><i class="bi bi-plus-circle me-2"></i>Registrar / consultar libros</a><a class="btn btn-outline-primary text-start" href="lectores.php"><i class="bi bi-person-plus me-2"></i>Registrar lectores</a><a class="btn btn-outline-primary text-start" href="prestamos.php"><i class="bi bi-journal-plus me-2"></i>Gestionar préstamos</a></div></div><div class="alert alert-info mt-3 small"><strong>Consejo:</strong> registre primero los libros y lectores para poder generar préstamos.</div></div></div>
<?php require 'partials/footer.php'; ?>
