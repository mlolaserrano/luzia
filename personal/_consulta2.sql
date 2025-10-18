-- Ver las BD
SHOW DATABASES;

-- llamar la entidad
USE ubicacion;

-- Ver tablas
SHOW tables;

--Ver estructura de tablas
DESCRIBE pais;

-- 1)
SELECT * FROM ubicacion.pais;

-- 2)
SELECT * FROM ubicacion.provincia LIMIT 10;

-- 3)
SELECT * FROM ubicacion.provincia WHERE idpais=2;
-- la clausula se llama where, me va a devolver todas las provincias cuyo id sea 2

-- 4)
SELECT * FROM ubicacion.provincia 
WHERE nombre LIKE '%jua%';

-- 5)
SELECT * FROM ubicacion.provincia
WHERE id IN (5,6,7,8);

SELECT * FROM ubicacion.provincia
WHERE id BETWEEN 5 AND 8;

SELECT * FROM ubicacion.provincia
WHERE id=5 OR id=6 OR id=7 OR id=8;

-- 6)
SELECT * FROM ubicacion.provincia
WHERE id IN (1,2,3,4);

-- 7)
SELECT * FROM ubicacion.pais
INNER JOIN ubicacion.provincia ON pais.id=provincia.idpais
WHERE pais.nombre='Argentina'
and provincia.nombre like '%san%';

--8 bis ) ordenado por provincia
SELECT pais.nombre AS pais,
provincia.nombre AS Provincia
FROM pais
INNER JOIN provincia ON pais.id=provincia.idpais
WHERE pais.nombre='Argentina'
ORDER BY provincia.nombre ASC;
 --DESC

-- 9)

select pais.nombre as Pais, provincia.nombre as Provincia, departamento.nombre as Departamento 
from pais
    INNER JOIN provincia ON pais.id=provincia.idpais
    INNER JOIN departamento ON provincia.id=departamento.idprovincia
where provincia.nombre like '%bue%'
LIMIT 20;

-- 10)
select pais.nombre as Pais, provincia.nombre as Provincia, sum(poblacion.valor) as Poblacion, anio.numero as Año 
from pais
    INNER JOIN provincia ON provincia.idpais = pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
where provincia.id = 2
group by anio.id;

-- 11)
select pais.nombre as Pais, provincia.nombre as Provincia, count(poblacion.valor) as 'Cantidad Dpto.', anio.numero as Año 
from pais
    INNER JOIN provincia ON provincia.idpais = pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
where provincia.id = 2
group by anio.id;

-- 12)

Select LEFT(pais.nombre, 3) as Pais, LEFT(provincia.nombre, 3) as 'Prov.', 
       departamento.nombre as Departamento, anio.numero as Año, 
       poblacion.valor as Poblacion, superficie.valor as Superficie 
from pais
    INNER JOIN provincia ON provincia.idpais = pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento = departamento.id
where anio.id = 10 and poblacion.valor > 450000
order by poblacion.valor desc;

-- 13)

Select LEFT(pais.nombre, 3) as Pais, LEFT(provincia.nombre, 3) as 'Prov.',
       departamento.nombre as Departamento, anio.numero as Año,
       poblacion.valor as Poblacion, superficie.valor as Superficie
from pais
    INNER JOIN provincia ON provincia.idpais = pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento = departamento.id
where anio.id = 10 and poblacion.valor > 450000
order by poblacion.valor desc;



-- 14)
Select LEFT(pais.nombre, 3) as Pais, LEFT(provincia.nombre, 3) as 'Prov.',
       departamento.nombre as Departamento, avg(poblacion.valor) as Poblacion,
       superficie.valor as Superficie
from pais
    INNER JOIN provincia ON provincia.idpais = pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento = departamento.id
where anio.numero = 2010 or anio.numero = 2001
group by departamento.id
having avg(poblacion.valor) > 450000
order by poblacion.valor desc;

-- 15)
Select LEFT(pais.nombre, 4) as Pais, LEFT(provincia.nombre, 3) as 'Prov.',
       LEFT(departamento.nombre, 12) as Departamento, anio.numero as Año,
       poblacion.valor as Poblacion, superficie.valor as Superficie,
       ROUND(poblacion.valor / superficie.valor, 2) as Densidad
from pais
    INNER JOIN provincia ON provincia.idpais = pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento = departamento.id
where anio.id = 10 and poblacion.valor > 450000
group by departamento.id
order by Densidad desc;
