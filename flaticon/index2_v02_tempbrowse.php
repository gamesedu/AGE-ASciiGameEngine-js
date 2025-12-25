<?php
$mainDirectory = 'flaticon'; // Specify the main directory containing the subfolders
$mainDirectory = '.'; // Set the initial directory for navigating

// Function to get all image files from a directory
function getImagesFromDir($dir) {
    $images = array();
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $path = $dir . '/' . $entry;
                if (is_dir($path)) {
                    // Skip directories for image fetching
                    continue;
                } elseif (preg_match('/\.(jpg|jpeg|png|gif)$/i', $entry)) {
                    $images[] = $path;
                }
            }
        }
        closedir($handle);
    }
    return $images;
}

// Function to get subfolders from a directory
function getSubfolders($dir='.') {
    $subfolders = array();
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && is_dir($dir . '/' . $entry)) {
                $subfolders[] = $entry;
            }
        }
        closedir($handle);
    }
    return $subfolders;
}

// Get the selected folder from the query parameter
$selectedFolder = isset($_GET['folder']) ? $_GET['folder'] : '';

// Validate the selected folder
if ($selectedFolder && is_dir($mainDirectory . '/' . $selectedFolder)) {
    $directory = $mainDirectory . '/' . $selectedFolder; // Set the directory to the selected folder
} else {
    $directory = $mainDirectory; // Default to the main directory if no valid folder is selected
}

// Get subfolders from the main directory
$subfolders = getSubfolders($mainDirectory);

// Display the subfolders as clickable links
echo '<h2>Subfolders:</h2>';
echo '<ul>';
foreach ($subfolders as $subfolder) {
    echo '<li><a href="?folder=' . urlencode($subfolder) . '">' . htmlspecialchars($subfolder) . '</a></li>';
}
echo '</ul>';

// Get all images from the selected directory
$images = getImagesFromDir($directory);

// Display the images in a table
echo '<h2>Images:</h2>';
echo '<table>';
$rowCount = 0; // Initialize a counter for images
foreach ($images as $image) {
    // If it's the first image in the row, start a new table row
    if ($rowCount % 8 == 0) {
        echo '<tr>';
    }

    echo '<td><img src="' . htmlspecialchars($image) . '" alt="Image" style="max-width:150px; max-height:150px;"></td>';

    // Increment the counter
    $rowCount++;

    // If it's the end of the row (8 images), close the row
    if ($rowCount % 8 == 0) {
        echo '</tr>';
    }
}

// If there are any remaining images not fitting into a complete row, close the row
if ($rowCount % 8 != 0) {
    echo '</tr>';
}
echo '</table>';
?>