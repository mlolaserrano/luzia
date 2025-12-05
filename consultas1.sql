show tables;

use luz

describe producto;

select* from usuario;

select*from usuario limit 10;

select * from usuario where id=2;

select * from usuario where id in  (1, 2, 3);

select from usuario

select * from producto;

select nombre, precio from producto where estado='activo';

select nombre,apellido,email,clave from usuario WHERE rol='cliente';

select * from cupon where in asc = 1 de enero de 2025;

describe usuario;

INSERT INTO usuario (dni, nombre, apellido, email, telefono, clave, rol)
VALUES (65239874, 'Martina', 'Díaz', 'martina.diaz@gmail.com', 1158796541, 'Marti2025*', 'cliente');

select * from producto;
....

select nombre,apellido, email from usuario;

select * from cupon where vigencia > 2025-01-01;

select * from producto;

select nombre, precio from producto where estado = 'activo';

select nombre, apellido, email from usuario;

select * from cupon where vigencia > 2025-01-01;

select *  from pedido where estado ='en almacen';

select * from cupon where monto BETWEEN 15000 and 30000;

select *from usuario  where nombre like = 'L%';
UPDATE producto SET stock = stock - 2 WHERE id = 3;

select * from pedido vigencia>2025-10;