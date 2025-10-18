SHOW DATABASES;

use luzia;

SHOW TABLES;

DESCRIBE usuario;

SELECT * FROM usuario;

INSERT INTO usuario 
(id,dni,nombre,apellido,email,telefono,clave,rol) 
VALUES 
(null,18456456,"Juan","Perez","lalala@lalal.com",456456,"fd22",'cliente');

INSERT INTO usuario 
(id,dni,nombre,apellido,email,telefono,clave,rol) 
VALUES 
(null,45852456,"Lorenzo","Ropero","lorenzo@lalal.com",45454,"dfdffd55",'cliente'),
(null,43258852,"Loana","Romero","Luana@lalal.com",44444,"445rgdg",'cliente');

UPDATE usuario SET email ="lorenzo@gmail.com" WHERE id =36;

DELETE FROM usuario WHERE id=33;

SELECT * FROM usuario
WHERE dni LIKE '6%';

SELECT pedido.id AS id, producto.sku AS Código, producto.nombre AS Producto, pedido.fecha AS Fecha, pedido.cantidad AS Cantidad, pedido.total AS Total
FROM pedido
INNER JOIN producto ON producto.id = pedido.id_producto
WHERE producto.nombre LIKE '%BRA%';