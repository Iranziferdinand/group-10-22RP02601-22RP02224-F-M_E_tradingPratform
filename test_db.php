<?php
require_once 'util.php';

try {
    $conn = new PDO("mysql:host=" . Util::$host . ";dbname=" . Util::$db, Util::$user, Util::$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test query
    $stmt = $conn->query("SHOW TABLES");
    echo "<h2>Database Connection Test</h2>";
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    echo "<h3>Tables in database:</h3>";
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "<h2>Database Connection Error</h2>";
    echo "<p style='color: red;'>✗ Connection failed: " . $e->getMessage() . "</p>";
}
?> 