<!DOCTYPE html>
<html>
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkte</title>
</head>
 
<body>
    <nav>
        <ul>
            <li><a href="index.php">Startseite</a></li>
            <li><a href="produkte.php">Produkte</a></li>
            <li><a href="warenkorb.php">Warenkorb</a></li>
        </ul>
    </nav>
 
    <h1>Warenkorb</h1>
 
    <?php require_once "login.php" ?>
 
    <?php
    session_start();
 
    // Produkt aus dem Warenkorb entfernen
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product'])) {
        $remove_id = $_POST['remove_id'];
 
        // Überprüfen, ob der Warenkorb existiert
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['id'] == $remove_id) {
                    // Produkt aus dem Warenkorb entfernen
                    unset($_SESSION['cart'][$index]);
                    echo "Produkt wurde erfolgreich aus dem Warenkorb entfernt.";
                    break;
                }
            }
 
            // Array neu indexieren, um Lücken zu vermeiden
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
 
    // Überprüfen, ob der Warenkorb existiert und Produkte enthält
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        echo "<ul>";
 
        foreach ($_SESSION['cart'] as $item) {
            echo "<li>";
            echo "Produkt: " . htmlspecialchars($item['name']) . " - Preis: " . htmlspecialchars($item['price']) . " €";
            ?>
            <form action="warenkorb.php" method="POST">
                <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                <button name="remove_product" type="submit">Entfernen</button>
            </form>
            <?php
            echo "</li>";
        }
 
        echo "</ul>";
    } else {
        echo "<p>Ihr Warenkorb ist leer.</p>";
        echo "<p>Vielen Dank, dass Sie unseren Shop nutzen!</p>";

    }
    ?>
 
</body>
 
</html>