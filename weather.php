<?php
$city = $_GET['city'];
$apiKey = 'a8ff7860b3dbc62afde34425544f9e1c'; //Api key from openweathermap
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
$response = file_get_contents($apiUrl); // Fetch weather data from OpenWeatherMap API
if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch weather data. Please try again.']); // Check if fetching weather data was successful
    exit;
}
$data = json_decode($response); // Parses the JSON response

if (!$data || isset($data->cod) && $data->cod !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Invalid weather data received. Please try again.']); // Check if the weather data is valid
    exit;
}
http_response_code(200);
header('Content-Type: application/json');
echo json_encode($data); // Sends a successful response with weather data