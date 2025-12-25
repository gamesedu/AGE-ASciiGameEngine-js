<?php

// Array to hold generated code
$outputLines = [];

// cURL setup options
function fetch_html_with_curl($url) {
    echo "<li>Fetching URL: $url\n"; // Debug: Show which URL is being fetched

    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // Randomize User-Agent
    $userAgents = [
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/74.0 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0",
    ];
    $randomUserAgent = $userAgents[array_rand($userAgents)];
    curl_setopt($ch, CURLOPT_USERAGENT, $randomUserAgent);

    // Referer header
    curl_setopt($ch, CURLOPT_REFERER, "https://www.flaticon.com/free-icons/character/");

    // Handle cookies
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');  // Save cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); // Load cookies
    
    // Enable verbose output for debugging
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);

    // Execute the cURL request
    $html = curl_exec($ch);

    // Check for errors
    if(curl_errno($ch)) {
        echo "<HR>cURL Error: " . curl_error($ch) . "\n";
        $html = false;
    }

    // Get verbose log and print for debugging
    fseek($verbose, 0);
    $verboseLog = stream_get_contents($verbose);
    echo "<HR>cURL Debug Output:\n$verboseLog\n"; // Print the verbose log

    // Close cURL and the verbose stream
    curl_close($ch);
    fclose($verbose);

    return $html;
}

// Loop through the URLs from 1 to 20
for ($i = 1; $i <= 20; $i++) {
    $url = "https://www.flaticon.com/free-icons/character/" . $i;

    // Fetch the HTML content using cURL
    $html = fetch_html_with_curl($url);
    if ($html === false) {
        echo "<BR>Failed to fetch $url\n";
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
echo "<BR>PHP script has been generated: $outputFile\n";
?>
