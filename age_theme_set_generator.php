<?php
/*
 
v001 -250408a


CSV saved in the end of this file
*/


// Define the CSV file path
$csvFile = 'age_themes.csv';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the theme name and URLs from the form submission
    $themeName = filter_input(INPUT_POST, 'theme_name', FILTER_SANITIZE_STRING);
    $player = filter_input(INPUT_POST, 'player', FILTER_SANITIZE_URL);
    $enemy = filter_input(INPUT_POST, 'enemy', FILTER_SANITIZE_URL);
    $enemy2 = filter_input(INPUT_POST, 'enemy2', FILTER_SANITIZE_URL);
    $enemy3 = filter_input(INPUT_POST, 'enemy3', FILTER_SANITIZE_URL);
    $item1 = filter_input(INPUT_POST, 'item1', FILTER_SANITIZE_URL);
    $obstacle = filter_input(INPUT_POST, 'obstacle', FILTER_SANITIZE_URL);
    $goal = filter_input(INPUT_POST, 'goal', FILTER_SANITIZE_URL);
    $gold = filter_input(INPUT_POST, 'gold', FILTER_SANITIZE_URL);
    $wallType1 = filter_input(INPUT_POST, 'wallType1', FILTER_SANITIZE_URL);
    $wallType2 = filter_input(INPUT_POST, 'wallType2', FILTER_SANITIZE_URL);

    // Create an array with the theme name and URLs
    $data = [
        $themeName,
        $player,
        $enemy,
        $enemy2,
        $enemy3,
        $item1,
        $obstacle,
        $goal,
        $gold,
        $wallType1,
        $wallType2,
    ];

    // Append to the CSV file
    $fp = fopen($csvFile, 'a');
    if ($fp) {
        fputcsv($fp, $data); // Save the data as a CSV line
        fclose($fp);
        $message = "URLs saved successfully!";
    } else {
        $message = "Error opening the file.";
    }
}

// Read the CSV file contents to display in the table
$rows = [];
if (file_exists($csvFile)) {
    $fp = fopen($csvFile, 'r');
    while (($row = fgetcsv($fp)) !== false) {
        $rows[] = $row; // Append each row to the rows array
    }
    fclose($fp);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save URL Combinations</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Enter URL Combinations</h1>
    <form method="post" action="">
        <label for="theme_name">Theme Name:</label><br>
        <input type="text" id="theme_name" size=120 name="theme_name" required><br><br>

        <label for="player">Player (P):</label><br>
        <input type="text" id="player" size=120 name="player" required><br><br>

        <label for="enemy">Enemy (E):</label><br>
        <input type="text" id="enemy" size=120 name="enemy" required><br><br>

        <label for="enemy2">Enemy 2 (2):</label><br>
        <input type="text" id="enemy2" size=120 name="enemy2" required><br><br>

        <label for="enemy3">Enemy 3 (3):</label><br>
        <input type="text" id="enemy3" size=120 name="enemy3" required><br><br>

        <label for="item1">Item 1:</label><br>
        <input type="text" id="item1" size=120 name="item1" required><br><br>

        <label for="obstacle">Obstacle (#):</label><br>
        <input type="text" id="obstacle" size=120 name="obstacle" required><br><br>

        <label for="goal">Goal (End Game) (&):</label><br>
        <input type="text" id="goal" size=120 name="goal" required><br><br>

        <label for="gold">Gold ($):</label><br>
        <input type="text" id="gold" size=120 name="gold" required><br><br>

        <label for="wallType1">Wall Type 1 ([):</label><br>
        <input type="text" id="wallType1" size=120 name="wallType1" required><br><br>

        <label for="wallType2">Wall Type 2 (]):</label><br>
        <input type="text" id="wallType2" size=120 name="wallType2" required><br><br>

        <button type="submit">Save URLs</button>
    </form>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <h2>Current URL Combinations</h2>
    <table>
        <tr>
            <th>Theme Name</th>
            <th>Player (P)</th>
            <th>Enemy (E)</th>
            <th>Enemy 2 (2)</th>
            <th>Enemy 3 (3)</th>
            <th>Item 1</th>
            <th>Obstacle (#)</th>
            <th>Goal (End Game) (&)</th>
            <th>Gold ($)</th>
            <th>Wall Type 1 ([)</th>
            <th>Wall Type 2 (])</th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td>
                        <?php echo htmlspecialchars($cell); ?>
                        <?php if (filter_var($cell, FILTER_VALIDATE_URL)): ?>
                            <img height=32 src="<?php echo htmlspecialchars($cell); ?>" alt="Image for <?php echo htmlspecialchars($cell); ?>">

                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php
/*
current CSV: 
CarTraffic1,https://cdn-icons-png.flaticon.com/128/2175/2175411.png,https://cdn-icons-png.flaticon.com/128/15029/15029062.png,https://cdn-icons-png.flaticon.com/128/4011/4011399.png,https://www.flaticon.com/free-icon/transport_14932077,https://cdn-icons-png.flaticon.com/128/11644/11644166.png,https://cdn-icons-png.flaticon.com/128/7923/7923380.png,https://cdn-icons-png.flaticon.com/128/1018/1018675.png,https://cdn-icons-png.flaticon.com/128/18689/18689388.png,https://cdn-icons-png.flaticon.com/128/9924/9924684.png,https://cdn-icons-png.flaticon.com/128/12417/12417152.png
demo1b-Wolverine-dragons,https://cdn-icons-png.flaticon.com/128/14062/14062013.png,https://cdn-icons-png.flaticon.com/128/3262/3262558.png,https://cdn-icons-png.flaticon.com/128/1507/1507124.png,https://cdn-icons-png.flaticon.com/128/2790/2790435.png,https://cdn-icons-png.flaticon.com/128/16525/16525834.png,https://cdn-icons-png.flaticon.com/128/685/685022.png,https://cdn-icons-png.flaticon.com/128/1505/1505465.png,https://cdn-icons-png.flaticon.com/128/4910/4910995.png,https://cdn-icons-png.flaticon.com/128/8568/8568554.png,https://cdn-icons-png.flaticon.com/128/9920/9920949.png
Wizard1,https://cdn-icons-png.flaticon.com/128/1680/1680365.png,https://cdn-icons-png.flaticon.com/128/2732/2732391.png,https://cdn-icons-png.flaticon.com/128/10033/10033388.png,https://cdn-icons-png.flaticon.com/128/2850/2850625.png,https://cdn-icons-png.flaticon.com/128/867/867906.png,https://cdn-icons-png.flaticon.com/128/3619/3619374.png,https://cdn-icons-png.flaticon.com/128/867/867845.png,https://cdn-icons-png.flaticon.com/128/8913/8913839.png,https://cdn-icons-png.flaticon.com/128/2139/2139359.png,https://cdn-icons-png.flaticon.com/128/3426/3426143.png
NinjaTurtles,https://cdn-icons-png.flaticon.com/128/1507/1507155.png,https://cdn-icons-png.flaticon.com/128/1507/1507099.png,https://cdn-icons-png.flaticon.com/128/1507/1507104.png,https://cdn-icons-png.flaticon.com/128/1507/1507221.png,https://cdn-icons-png.flaticon.com/128/9256/9256790.png,https://cdn-icons-png.flaticon.com/128/313/313075.png,https://cdn-icons-png.flaticon.com/128/1507/1507238.png,https://cdn-icons-png.flaticon.com/128/18263/18263754.png,https://cdn-icons-png.flaticon.com/128/7079/7079711.png,https://cdn-icons-png.flaticon.com/128/5527/5527064.png
PacMan1,https://cdn-icons-png.flaticon.com/128/11379/11379091.png,https://cdn-icons-png.flaticon.com/128/13929/13929021.png,https://cdn-icons-png.flaticon.com/128/11383/11383207.png,https://cdn-icons-png.flaticon.com/128/13822/13822949.png,https://cdn-icons-png.flaticon.com/128/15636/15636528.png,https://cdn-icons-png.flaticon.com/128/6742/6742720.png,https://cdn-icons-png.flaticon.com/128/2163/2163350.png,https://cdn-icons-png.flaticon.com/128/8822/8822223.png,https://cdn-icons-png.flaticon.com/128/17235/17235366.png,https://cdn-icons-png.flaticon.com/128/6387/6387581.png
Jungle1,https://cdn-icons-png.flaticon.com/128/3251/3251231.png,https://cdn-icons-png.flaticon.com/128/3501/3501292.png,https://cdn-icons-png.flaticon.com/128/3788/3788222.png,https://cdn-icons-png.flaticon.com/128/3819/3819195.png,https://cdn-icons-png.flaticon.com/128/10922/10922193.png,https://cdn-icons-png.flaticon.com/128/8029/8029256.png,https://cdn-icons-png.flaticon.com/128/2991/2991502.png,https://cdn-icons-png.flaticon.com/128/190/190905.png,https://cdn-icons-png.flaticon.com/128/7922/7922738.png,https://cdn-icons-png.flaticon.com/128/1777/1777022.png
Alien1,https://cdn-icons-png.flaticon.com/128/18284/18284410.png,https://cdn-icons-png.flaticon.com/128/4925/4925652.png,https://cdn-icons-png.flaticon.com/128/4925/4925762.png,https://cdn-icons-png.flaticon.com/128/10720/10720813.png,https://cdn-icons-png.flaticon.com/128/10201/10201562.png,https://cdn-icons-png.flaticon.com/128/560/560876.png,https://cdn-icons-png.flaticon.com/128/6580/6580111.png,https://cdn-icons-png.flaticon.com/128/80/80643.png,https://cdn-icons-png.flaticon.com/128/6580/6580141.png,https://cdn-icons-png.flaticon.com/128/433/433871.png

*/

?>