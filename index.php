<?php
// Handle AJAX requests to update or fetch counter values
$filename = 'counter.json';

// Load counter values from file
if (file_exists($filename)) {
    $data = json_decode(file_get_contents($filename), true);
} else {
    // Initialize with zero values if the file does not exist
    $data = ['likes' => 0, 'views' => 0, 'shares' => 0];
}

// Process action from query parameters to update counters
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if (array_key_exists($action, $data)) {
        $data[$action]++;
        file_put_contents($filename, json_encode($data));
    }
    // Return updated counts
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Counter</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            font-family: 'Arial', sans-serif;
        }
        .counter {
            text-align: center;
            color: #fff;
        }
        .counter h1 {
            font-size: 5em;
            margin: 0;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7), 0 0 20px rgba(255, 255, 255, 0.5);
        }
        .counter p {
            font-size: 2em;
            margin: 10px 0;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7), 0 0 20px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="counter">
        <h1>TikTok Stats</h1>
        <p id="likes">Likes: 0</p>
        <p id="views">Views: 0</p>
        <p id="shares">Shares: 0</p>
    </div>

    <script>
        function updateCounters() {
            fetch(window.location.href)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('likes').textContent = 'Likes: ' + data.likes;
                    document.getElementById('views').textContent = 'Views: ' + data.views;
                    document.getElementById('shares').textContent = 'Shares: ' + data.shares;
                })
                .catch(error => console.error('Error fetching counter data:', error));
        }

        // Update counters every 5 seconds
        setInterval(updateCounters, 5000);

        // Initial fetch
        updateCounters();
    </script>
</body>
</html>
