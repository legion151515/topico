<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'topico_sigram';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Base de Datos MySQL</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        tr:hover { background: #f9f9f9; }
        .table-name { background: #1e3c72; color: white; padding: 15px; margin-top: 20px; font-weight: bold; border-radius: 4px; }
        .fk { color: #c0392b; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>📊 Estructura Base de Datos MySQL: topico_sigram</h1>

    <?php

    $query = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$database'";
    $tables = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

    echo "<p><strong>Total de tablas: " . count($tables) . "</strong></p>";

    foreach ($tables as $table) {
        $tableName = $table['TABLE_NAME'];
        
        echo "<div class='table-name'>📋 TABLA: $tableName</div>";
        
        $colQuery = "SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tableName'";
        $columns = $pdo->query($colQuery)->fetchAll(PDO::FETCH_ASSOC);
        
        $fkQuery = "SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tableName' AND REFERENCED_TABLE_NAME IS NOT NULL";
        $foreignKeys = $pdo->query($fkQuery)->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table>";
        echo "<tr><th>Columna</th><th>Tipo</th><th>Nullable</th><th>Clave</th><th>Clave Foránea</th></tr>";
        
        foreach ($columns as $col) {
            $colName = $col['COLUMN_NAME'];
            $type = $col['COLUMN_TYPE'];
            $nullable = $col['IS_NULLABLE'] === 'YES' ? 'SÍ' : 'NO';
            $key = $col['COLUMN_KEY'] ?: '-';
            
            $fkInfo = '-';
            foreach ($foreignKeys as $fk) {
                if ($fk['COLUMN_NAME'] === $colName) {
                    $fkInfo = "→ {$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']}";
                    break;
                }
            }
            
            $fkClass = $fkInfo !== '-' ? 'fk' : '';
            
            echo "<tr>";
            echo "<td><strong>$colName</strong></td>";
            echo "<td>$type</td>";
            echo "<td>$nullable</td>";
            echo "<td>$key</td>";
            echo "<td class='$fkClass'>$fkInfo</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }

    ?>
</div>

</body>
</html>
```

---

## **Paso 3: Abre en el navegador**
```
http://localhost/laravel/sigram-topico/ver-bd-mysql.php