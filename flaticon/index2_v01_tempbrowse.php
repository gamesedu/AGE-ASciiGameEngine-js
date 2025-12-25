<?php
$directory = 'flaticon'; // Specify the directory containing the subfolders
$directory = '.';

// Function to get all image files from a directory
function getImagesFromDir($dir) {
    $images = array();
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $path = $dir . '/' . $entry;
                if (is_dir($path)) {
                    $images = array_merge($images, getImagesFromDir($path));
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
function getSubfolders($dir) {
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

// Get all images from the specified directory and its subfolders
$images = getImagesFromDir($directory);

// Get subfolders from the specified directory
$subfolders = getSubfolders($directory);

// Display the subfolders as clickable links
echo '<h2>Subfolders:</h2>';
echo '<ul>';
foreach ($subfolders as $subfolder) {
    echo '<li><a href="?folder=' . $subfolder . '">' . $subfolder . '</a></li>';
}
echo '</ul>';

// Display the images in a table
echo '<h2>Images:</h2>';
echo '<table>';
$rowCount = 0; // Initialize a counter for images
foreach ($images as $image) {
    // If it's the first image in the row, start a new table row
    if ($rowCount % 8 == 0) {
        echo '<tr>';
    }

    echo '<td><img src="' . $image . '" alt="Image" style="max-width:150px; max-height:150px;"></td>';

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
