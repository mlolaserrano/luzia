
-- 1) Consultar todos los registros y todos los campos de la 
--    tabla pais.
--    https://www.w3schools.com/sql/sql_select.asp

select * from pais;

-- 2) Consultar los diez primeros registros 
--    y obtener todos los campos de la tabla provincia . 
--    Limitar la cantidad de registros de salida a 10.
--    https://www.w3schools.com/sql/sql_top.asp

select * from provincia LIMIT 10;

-- 3) Obtener las provincias que tienen un identificador de país 
--    específico. Para el caso listar las provincias con el id 
--    del pais 2.
--    https://www.w3schools.com/sql/sql_where.asp

select * from provincia where idPais=2;

-- 4) Obtener todas las provincias cuyo contenido del campo nombre 
--    contenga a la cadena 'jua'
--   https://www.w3schools.com/sql/sql_like.asp

select * from provincia where nombre like '%jua%';


-- 5) Obtener todos los campos de las provincias cuyo id se 
--    encuentre dentro de una lista específica. Para el caso 
--    la lista contiene 5,6,7,8
--    https://www.w3schools.com/sql/sql_in.asp
--    https://www.w3schools.com/sql/sql_between.asp

select * from provincia where id in (5,6,7,8);

-- 6) Obtener los nombres de las provincias cuyo id se encuentre 
--    dentro de una lista específica. Para el caso la lista 
--    contiene 1,2,3,4
--    
select nombre from provincia where id in (1,2,3,4);

-- 7) Obtener todas las provincias correspondientes 
--    al país “Argentina”.

select * from pais 
    INNER JOIN provincia ON pais.id=provincia.idpais 
    where pais.nombre like '%Argentina%';

-- 8) Obtener todos las provincias correspondientes al país 
--    “Argentina”. Modificar los títulos de las columnas de 
--    salida y mostrar sólo dos campos: El nombre del Pais 
--    indicarlo como “Pais” y el nombre de la provincia 
--    indicarlo como “Provincia”.
--    https://www.w3schools.com/sql/sql_alias.asp

select pais.nombre as Pais , provincia.nombre as Provincia from pais 
    INNER JOIN provincia ON pais.id=provincia.idpais 
    where pais.nombre like '%Argentina%';

-- OTRA FORMA
select pais.nombre as Pais, provincia.nombre as Provincia from pais 
    INNER JOIN provincia ON pais.id=provincia.idpais 
    where provincia.idpais=
        (select id from pais where pais.nombre like '%Argentina%');

-- 9) Obtener todos los departamentos de la provincia de Buenos Aires. 
--    Listar los campos Pais, Provincia, Departamento. Limitar la salida 
--    a sólo 20 registros.
--    

select pais.nombre as Pais, provincia.nombre as Provincia, 
       departamento.nombre as Departamento from pais 
    INNER JOIN provincia ON pais.id=provincia.idpais 
    INNER JOIN departamento ON provincia.id=departamento.idprovincia
where provincia.nombre like '%bue%'
LIMIT 20;

-- 10) Idem al anterior, pero se agrega la columna superficie 
--     para cada departamento.

select pais.nombre as Pais, provincia.nombre as Provincia, departamento.nombre as departamento, superficie.valor as Superficie from pais
    INNER JOIN provincia ON pais.id=provincia.idpais 
    INNER JOIN departamento ON provincia.id=departamento.idprovincia
    INNER JOIN superficie ON departamento.id=superficie.idDepartamento
where provincia.nombre like '%bue%'
LIMIT 20;

-- 11) Obtener la población de la provincia de Buenos Aires al 2001 y al 2010. 
--     Listar los campos Pais, Provincia, Población y Año. Se sabe que 
--     el id de Buenos Aires es 2.
--     https://www.w3schools.com/sql/sql_groupby.asp

select pais.nombre as Pais, provincia.nombre as Provincia,sum(poblacion.valor) as Poblacion, anio.numero as Año from pais
    INNER JOIN provincia ON provincia.idpais=pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio 
where provincia.id=2
 group by anio.id;


-- 12 )  Obtener la cantidad de departamentos de la provincia de Buenos Aires 
--       (para cada año) que tienen registrada la Población. 
--       Listar País, Provincia, Cantidad Dpto y Año.

select pais.nombre as Pais, provincia.nombre as Provincia, count(poblacion.valor) as 'Cantidad Dpto.', anio.numero as Año from pais
    INNER JOIN provincia ON provincia.idpais=pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
where provincia.id=2
group by anio.id;


-- 13) Obtener un listado de los departamentos para la provincia de Buenos Aires 
--     en el año 2010 y cuya población sea superior a 450000. Listar País, 
--     Provincia, Departamento, Año, Población y Superficie. Ordenar el 
--     listado en forma descendente por cantidad de población. Recortar 
--     a tres caracteres el contenido de los campos Pais y Provincia.
--     https://www.w3schools.com/sql/sql_orderby.asp

Select LEFT(pais.nombre, 3) as Pais, LEFT(provincia.nombre, 3) as 'Prov.', departamento.nombre as Departamento, anio.numero as Año, poblacion.valor as Poblacion, superficie.valor as Superficie from pais
    INNER JOIN provincia ON provincia.idpais=pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento=departamento.id
where anio.id=10 and poblacion.valor > 450000 
order by poblacion.valor desc;

-- 14) Obtener un listado de los departamentos de la provincia de Buenos Aires 
--     para el año 2001 y 2010,  agrupado por id de departamento cuyo promedio 
--     de población sea superior    a 450000. Listar País, Provincia, 
--     Departamento, Población y Superficie. Ordenar el listado en forma 
--     descendente por cantidad de población. Recortar a tres caracteres 
--     el contenido de los campos País y Provincia.
--    https://www.w3schools.com/mysql/mysql_ref_functions.asp
--    https://www.w3schools.com/sql/sql_having.asp
--    https://www.datacamp.com/community/tutorials/group-by-having-clause-sql?utm_source=adwords_ppc&utm_campaignid=1455363063&utm_adgroupid=65083631748&utm_device=c&utm_keyword=&utm_matchtype=b&utm_network=g&utm_adpostion=&utm_creative=332602034358&utm_targetid=aud-748597547652:dsa-429603003980&utm_loc_interest_ms=&utm_loc_physical_ms=1000073&gclid=CjwKCAjwndCKBhAkEiwAgSDKQS9FGYPAAup8ruHF8HwgduoacR5jQ-UVSBrrpq4oegMDEqum2JPw0RoCaioQAvD_BwE

Select LEFT(pais.nombre, 3) as Pais, LEFT(provincia.nombre, 3) as 'Prov.', 
departamento.nombre as Departamento, avg(poblacion.valor) as Poblacion, 
superficie.valor as Superficie from pais
    INNER JOIN provincia ON provincia.idpais=pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento=departamento.id
where anio.numero=2010 or  anio.numero=2001
group by departamento.id 
having avg(poblacion.valor) > 450000 
order by poblacion.valor desc;



-- 15) Obtener un listado de los departamentos de para la provincia de Buenos Aires 
--     para el año 2010,  agrupado por id de departamento , y cuyo promedio de 
--     población sea superior    a 450000. Listar País, Provincia, Departamento, 
--     Población, Superficie y Densidad de Población . Ordenar el listado en forma 
--     descendente por Densidad de Población. Recortar a tres caracteres el contenido 
--     de los campos País y Provincia.
--     Nota: Densidad de población= Población / Superficie

Select LEFT(pais.nombre, 3) as Pais, LEFT(provincia.nombre, 3) as 'Prov.', LEFT(departamento.nombre,12) as Departamento, anio.numero as Año, poblacion.valor as Poblacion, superficie.valor as Superficie,  ROUND(poblacion.valor /superficie.valor ,2)as Densidad from pais
    INNER JOIN provincia ON provincia.idpais=pais.id
    INNER JOIN departamento ON departamento.idprovincia = provincia.id
    INNER JOIN poblacion ON poblacion.idDepartamento = departamento.id
    INNER JOIN anio ON anio.id = poblacion.idAnio
    INNER JOIN superficie ON superficie.idDepartamento=departamento.id
where anio.id=10 and poblacion.valor > 450000 
group by departamento.id
order by Densidad desc;















