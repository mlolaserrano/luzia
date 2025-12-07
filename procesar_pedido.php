<?php
session_start();
require __DIR__ . '/conexion.php';

// 1) Verificar que el usuario esté logueado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// 2) Verificar que el carrito NO esté vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit();
}

$carrito = $_SESSION['carrito'];
$email   = $_SESSION['email'];

// 3) Buscar datos del usuario en la tabla `usuario`
$stmt = $conn->prepare("
    SELECT id, nombre
    FROM usuario
    WHERE email = ?
    LIMIT 1
");
$stmt->execute([$email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    // Si no encuentra el usuario, volvemos al login
    header("Location: login.php");
    exit();
}

$id_usuario = (int)$usuario['id'];

// 4) Definir SIEMPRE un cupón válido
// Usamos el cupón "SinCodigo" que en tu tabla cupon tiene id = 1
$id_cupon        = 1;   // NO es null
$cupon_descuento = 0;   // Descuento 0 por defecto
$estado          = 'pendiente'; // ← estado inicial del pedido

try {
    $conn->beginTransaction();

    $ultimo_id_pedido = null;

    // 5) Preparar el INSERT en `pedido`
    // OJO: en la base la columna es id_usuario, NO id_cliente
    $stmt_pedido = $conn->prepare("
        INSERT INTO pedido
            (id_usuario, id_producto, id_cupon, fecha, cantidad, estado,
             precio, montobruto, cupon_descuento, total)
        VALUES
            (?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, ?)
    ");

    foreach ($carrito as $item) {
        // Ajustá estos índices si tu carrito tiene otros nombres
        $id_producto = (int)$item['id'];          // ID del producto (desde el carrito)
        $cantidad    = (int)$item['cantidad'];
        $precio      = (float)$item['precio'];   // precio unitario

        $montobruto = $precio * $cantidad;
        $total      = $montobruto - $cupon_descuento;

        $stmt_pedido->execute([
            $id_usuario,        // id_usuario (FK a usuario.id)
            $id_producto,       // id_producto
            $id_cupon,          // id_cupon (1 = SinCodigo)
            $cantidad,          // cantidad
            $estado,            // estado = 'pendiente'
            $precio,            // precio unitario
            $montobruto,        // montobruto
            $cupon_descuento,   // cupon_descuento
            $total              // total
        ]);

        // Me guardo el último id para enviarlo a la página de confirmación
        $ultimo_id_pedido = $conn->lastInsertId();
    }

    $conn->commit();

    // 6) Vaciar carrito
    $_SESSION['carrito'] = [];

    // 7) Redirigir a la página de confirmación (con el último id insertado)
    header("Location: pedido_confirmado.php?pedido=" . $ultimo_id_pedido);
    exit();

} catch (Exception $e) {
    $conn->rollBack();
    echo "Error al procesar el pedido: " . $e->getMessage();
}
