<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Replace with your valid Gemini API key
$apiKey = "AIzaSyCJSHHkxPXivCudZmrG_qvazCctV3BNTyU";

// Get the JSON input from the request body
$input = json_decode(file_get_contents("php://input"), true);
if (!$input || !isset($input["lang"], $input["texts"])) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$lang = $input["lang"];
$texts = $input["texts"];

// Build a prompt that instructs Gemini to return a JSON array of translated strings.
// (Make sure to include instructions like "Return only a JSON array" so that Gemini returns clean output.)
$prompt = "Translate the following English texts to $lang. Return only a JSON array of translated strings in the same order, without any additional explanation:\n\n" . json_encode($texts);

// Prepare the payload for Gemini
$payload = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
];

// Set up the URL using the beta endpoint and the correct model name
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

// Decode the Gemini API response
$result = json_decode($response, true);

// Initialize an empty array for translations
$translations = [];

if (isset($result['candidates']) && count($result['candidates']) > 0) {
    // Extract the text from the first candidate's content parts
    $candidateText = $result['candidates'][0]['content']['parts'][0]['text'] ?? "";
    
    // Try to decode the candidate text as a JSON array (if Gemini followed the prompt exactly)
    $decodedArray = json_decode($candidateText, true);
    
    if (is_array($decodedArray)) {
        $translations = $decodedArray;
    } else {
        // If decoding fails, assume that candidateText is a plain translation.
        // We'll wrap it in an array so that the JS code can work with it.
        $translations = [trim($candidateText)];
    }
    
    echo json_encode($translations);
} else {
    echo json_encode([
        "error" => "No valid candidates found.",
        "raw" => $response
    ]);
}
