# SOLUCIÓN AL ERROR DE FOREIGN KEY CONSTRAINT

## Problema
El error ocurría porque `carrera_id` estaba recibiendo un texto ("Primaria") en lugar de un ID numérico.

## Soluciones Aplicadas

### 1. Validación en el Controlador
Se agregó validación en `AtencionController.php` para:
- Verificar que `carrera_id` sea numérico antes de usarlo
- Si no es numérico, buscar la carrera por nombre y obtener su ID
- Si no se encuentra, usar NULL

### 2. Asegurar que las Carreras Existan en la Base de Datos

**IMPORTANTE:** Debes ejecutar el seeder de carreras para que la tabla `carreras` tenga datos.

```bash
# Ejecutar el seeder de carreras
php artisan db:seed --class=CarreraSeeder

# O ejecutar todos los seeders
php artisan db:seed
```

### 3. Verificar que las Carreras Fueron Cargadas

```bash
# Conectarse a la base de datos y verificar
php artisan tinker

# Dentro de tinker, ejecutar:
\App\Models\Carrera::all();

# Deberías ver 11 carreras:
# - 4 de categoría Tecnológico
# - 4 de categoría Pedagógico
# - 3 de categoría Escuela (Inicial, Primaria, Secundaria)
```

### 4. Migración de la Tabla Pacientes

Si necesitas hacer que `carrera_id` sea nullable (opcional), ejecuta esta migración:

```bash
php artisan make:migration make_carrera_id_nullable_in_pacientes_table
```

Luego edita el archivo de migración y agrega:

```php
public function up()
{
    Schema::table('pacientes', function (Blueprint $table) {
        $table->integer('carrera_id')->nullable()->change();
    });
}
```

Y ejecuta:

```bash
php artisan migrate
```

## Logging Mejorado

Se agregó logging detallado en el controlador para debugging:
- Log de todos los valores del request
- Log del tipo de dato de carrera_id
- Log de advertencia cuando carrera_id no es numérico
- Log de conversión cuando se busca por nombre

## Próximos Pasos

1. Ejecuta `php artisan db:seed --class=CarreraSeeder`
2. Intenta registrar una nueva atención
3. Revisa los logs en `storage/logs/laravel.log` para ver el proceso completo
4. Si persiste el error, comparte los nuevos logs para más análisis

## Nota Adicional

Si después de ejecutar el seeder aún tienes problemas, verifica que:
- El campo `carrera_id` en el formulario HTML está correctamente configurado
- El JavaScript está cargando las carreras correctamente desde `/carreras/{categoria}`
- El archivo `.env` tiene la configuración correcta de la base de datos
