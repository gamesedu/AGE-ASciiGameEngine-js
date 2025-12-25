<?php

// Array to hold generated code
$outputLines = [];

// Loop through the URLs from 1 to 20
for ($i = 1; $i <= 20; $i++) {
    $url = "https://www.flaticon.com/free-icons/character/" . $i;
           //" ttps://www.flaticon.com/free-icons/character/1"

    // Create stream context with user agent
$options = [
    "http" => [
        "header" => [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36",
            "Referer: https://www.flaticon.com/"
        ]
    ]
];
    $context = stream_context_create($options);

    // Fetch the HTML content
    $html = file_get_contents($url, false, $context);
    if ($html === false) {
        echo "Failed to fetch $url\n";
        continue; // Skip this URL if fetching fails
    }

    // Use DOMDocument to parse the HTML
    $dom = new DOMDocument();
    @$dom->loadHTML($html); // Suppress warnings with @

    // Use DOMXPath to query for data-png attributes
    $xpath = new DOMXPath($dom);
    $images = $xpath->query('//*[@data-png]');

    // Process each found image
    foreach ($images as $img) {
        $dataPng = $img->getAttribute('data-png');

        // Extract the image ID from the URL
        preg_match('/\/([^\/]+)\.png$/', $dataPng, $matches);
        if (isset($matches[1])) {
            $imageId = $matches[1];

            // Modify the URL
            $newUrl = str_replace('/512/', '/64/', $dataPng);

            // Generate the PHP line
            $outputLines[] = "file_put_contents('flaticon.com_$imageId.png', file_get_contents('$newUrl'));";
        }
    }
}

// Write the generated PHP code to a file
$outputFile = 'download_images.php';
file_put_contents($outputFile, "<?php\n\n// Image download script\n\n" . implode("\n", $outputLines) . "\n");
echo "PHP script has been generated: $outputFile\n";
?>