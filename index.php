<?php
require_once 'Menu.php';
require_once 'Util.php';

try {
    $conn = new PDO("mysql:host=" . Util::$host . ";dbname=" . Util::$db, Util::$user, Util::$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sessionId = '';
    $serviceCode = '';
    $phoneNumber = '';
    $text = '';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // USSD request handling
        if (isset($_POST["sessionId"])) {
            $sessionId = $_POST["sessionId"];
        }
        if (isset($_POST["serviceCode"])) {
            $serviceCode = $_POST["serviceCode"];
        }
        if (isset($_POST["phoneNumber"])) {
            $phoneNumber = $_POST["phoneNumber"];
        }
        if (isset($_POST["text"])) {
            $text = $_POST["text"];
        }

        // Validate required fields for USSD
        if (empty($phoneNumber)) {
            echo "END Invalid phone number. Please try again.";
            exit;
        }

        // Format phone number if needed
        if (strpos($phoneNumber, '+') !== 0) {
            $phoneNumber = '+' . $phoneNumber;
        }
    } else {
        // Direct web access - show database status
        header('Content-Type: text/html; charset=utf-8');
        echo "<h2>F&I MOMO USSD Application Status</h2>";
        
        // Check database connection
        try {
            $testQuery = $conn->query("SELECT 1");
            echo "<p style='color: green;'>✓ Database connection successful</p>";
            
            // Check required tables
            $tables = ['users', 'agents', 'transactions'];
            $missingTables = [];
            
            foreach ($tables as $table) {
                $result = $conn->query("SHOW TABLES LIKE '$table'");
                if ($result->rowCount() == 0) {
                    $missingTables[] = $table;
                }
            }
            
            if (empty($missingTables)) {
                echo "<p style='color: green;'>✓ All required tables exist</p>";
            } else {
                echo "<p style='color: red;'>✗ Missing tables: " . implode(', ', $missingTables) . "</p>";
                echo "<p>Please run the momo_app.sql script to create the missing tables.</p>";
            }
            
            // Show table statistics
            echo "<h3>Database Statistics:</h3>";
            echo "<ul>";
            foreach ($tables as $table) {
                $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch()['count'];
                echo "<li>$table: $count records</li>";
            }
            echo "</ul>";
            
        } catch (PDOException $e) {
            echo "<p style='color: red;'>✗ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        echo "<p><a href='http://localhost/phpmyadmin/' target='_blank'>Open phpMyAdmin</a></p>";
        exit;
    }

    // Initialize menu
    $menu = new Menu($text, $sessionId, $phoneNumber, $conn);

    // Process text input
    $text = $menu->middleWare($text);
    $textArray = explode("*", $text);

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
    $stmt->execute([$phoneNumber]);
    $user = $stmt->fetch();

    if (!$user) {
        if ($text == "") {
            $menu->mainMenuUnregistered(); // Show initial menu
        } else {
            // Route based on user's input
            if (isset($textArray[0])) {
                switch ($textArray[0]) {
                    case "1":
                        $menu->menuRegister($textArray);
                        break;
                    case "2":
                        $menu->RegisterAgent($textArray);
                        break;
                    default:
                        echo "END Invalid option. Please try again.";
                        break;
                }
            } else {
                echo "END Invalid input. Please try again.";
            }
        }
    } else {
        if (empty($text)) {
            $menu->mainMenuRegistered();
        } else {
            // Route based on user's input
            if (isset($textArray[0])) {
                switch ($textArray[0]) {
                    case "1":
                        $menu->menuSendMoney($textArray);
                        break;
                    case "2":
                        $menu->menuWithdrawMoney($textArray);
                        break;
                    case "3":
                        $menu->menuCheckBalance($textArray);
                        break;
                    case "4":
                        $menu->menuDepositMoney($textArray);
                        break;
                    default:
                        $menu->mainMenuRegistered();
                        break;
                }
            } else {
                $menu->mainMenuRegistered();
            }
        }
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "END Database error. Please try again later.";
    } else {
        echo "<p style='color: red;'>Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "END An error occurred. Please try again.";
    } else {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>