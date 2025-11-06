<?php
/**
 * Este archivo centraliza todas las consultas a la base de datos
 * relacionadas con la tabla 'producto' para la vista del cliente.
 */

/**
 * Obtiene todos los productos que están marcados como 'activos'.
 *
 * @param mysqli $conn El objeto de conexión a la base de datos.
 * @return mysqli_result|false El resultado de la consulta (para iterar) o false si falla.
 */
function obtenerTodosLosProductos($conn) {
    // Seleccionamos los campos que necesitamos para la tarjeta de producto
    $sql = 
    "SELECT id, nombre, descripcion, precio, imagen 
    FROM producto 
    WHERE estado = 'activo'"; //seleccionamos todos los productos activos
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === FALSE) {
        // Manejo de error (en un caso real, podrías loguear este error)
        echo "<p>Error al preparar consulta de todos los productos: " . htmlspecialchars($conn->error) . "</p>";
        return false;
    }
    
    $stmt->execute();
    return $stmt->get_result(); // Devuelve el set de resultados
}

/**
 * Obtiene todos los productos de una categoría específica que están 'activos'.
 *
 * @param mysqli $conn El objeto de conexión a la base de datos.
 * @param string $categoria El nombre de la categoría (ej. 'aros', 'anillos').
 * @return mysqli_result|false El resultado de la consulta (para iterar) o false si falla.
 */
function obtenerProductosPorCategoria($conn, $categoria) {
    // Usamos '?' como placeholder para la categoría
    $sql = 
    "SELECT id, nombre, descripcion, precio, imagen 
    FROM producto 
    WHERE categoria = ? AND estado = 'activo'"; //
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === FALSE) {
        echo "<p>Error al preparar consulta por categoría: " . htmlspecialchars($conn->error) . "</p>";
        return false;
    }
    
    // "s" significa que el parámetro es un string (cadena)
    $stmt->bind_param("s", $categoria); 
    
    $stmt->execute();
    return $stmt->get_result(); // Devuelve el set de resultados
}

/**
 * Obtiene los detalles completos de UN solo producto por su ID.
 *
 * @param mysqli $conn El objeto de conexión a la base de datos.
 * @param int $id El ID del producto a buscar.
 * @return array|null Un array asociativo con los datos del producto, o null si no se encuentra.
 */
function obtenerProductoPorId($conn, $id) {
    // Seleccionamos todos los campos necesarios para la página de 'detalle_producto'
    // Asegúrate de que estos nombres de columna (sku, material, etc.) existan en tu tabla
    $sql = "SELECT id, nombre, sku, descripcion, precio, imagen, material, tallas, peso 
            FROM producto 
            WHERE id = ? AND estado = 'activo'";
            
    $stmt = $conn->prepare($sql);
    
    if ($stmt === FALSE) {
        echo "<p>Error al preparar consulta por ID: " . htmlspecialchars($conn->error) . "</p>";
        return null;
    }
    
    // "i" significa que el parámetro es un integer (entero)
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // fetch_assoc() obtiene la (única) fila de resultado como un array
    return $result->fetch_assoc(); 
}

?>