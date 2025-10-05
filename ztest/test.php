<?php
require 'vendor/autoload.php'; // Include the library if installed via Composer
use Picqer\Barcode\BarcodeGeneratorHTML;

$barcodeValue = '4800301902395';

$generator = new BarcodeGeneratorHTML();
$barcode = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Display</title>
</head>
<body>
    <h1>Barcode for Item Code: <?php echo $barcodeValue; ?></h1>
    <div>
        <?php echo $barcode; ?>
    </div>

    <h1>Scan Barcode</h1>

    
    <form action="" method="post">
        <label for="barcode">Scan your barcode:</label>
        <input type="text" id="barcode" name="barcode" autofocus>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Check if barcode is set
    if (isset($_POST['barcode'])) {
        $barcode = $_POST['barcode'];
        echo "<h2>Scanned Barcode: " . htmlspecialchars($barcode) . "</h2>";
    }
    ?>
</body>
</html>





<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner Example</title>
</head>
<body>
    <h1>Scan Barcode</h1>
    <form action="" method="post">
        <label for="barcode">Scan your barcode:</label>
        <input type="text" id="barcode" name="barcode" autofocus>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Check if barcode is set
    if (isset($_POST['barcode'])) {
        $barcode = $_POST['barcode'];
        echo "<h2>Scanned Barcode: " . htmlspecialchars($barcode) . "</h2>";
    }
    ?>
</body>
</html> -->
