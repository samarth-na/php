<?php
// Save this file as "json_server.php"

// --- SERVER CONFIGURATION ---
// Define the server address and port
// 127.0.0.1 is localhost (only accessible from the same machine)
// Port 8000 is a common choice for development servers
$host = '127.0.0.1';
$port = 8000;

// --- SOCKET CREATION ---
// Create a socket for network communication
// AF_INET - Use IPv4 addressing (vs AF_INET6 for IPv6)
// SOCK_STREAM - Use TCP protocol (reliable, ordered delivery)
// SOL_TCP - Use TCP protocol options
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// --- SOCKET OPTIONS ---
// Enable address reuse to avoid "Address already in use" errors
// SOL_SOCKET - Socket level option (not protocol specific)
// SO_REUSEADDR - Allow reuse of local addresses
// 1 - Enable this option
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

// --- BIND SOCKET ---
// Bind the socket to our specified IP address and port
// This reserves this port for our application
socket_bind($socket, $host, $port);

// --- LISTEN FOR CONNECTIONS ---
// Put socket in listening mode to accept incoming connections
// The socket will queue connection requests until we accept them
socket_listen($socket);

// --- SERVER INFORMATION ---
// Display startup information in the terminal
echo "JSON Server started at http://$host:$port\n";
echo "Press Ctrl+C to stop the server\n";

// --- MAIN SERVER LOOP ---
// Infinite loop that runs until the script is terminated
// The server continuously accepts and processes requests
while (true) {
    // --- ACCEPT CLIENT CONNECTION ---
    // Wait for and accept an incoming connection
    // socket_accept creates a NEW socket specifically for this client
    // The original socket continues listening for more connections
    $client = socket_accept($socket);
    
    // --- READ CLIENT REQUEST ---
    // Read data sent by the client (HTTP request)
    // 1024 bytes should be enough for basic HTTP headers
    // For larger requests, you might need to read in a loop
    $request = socket_read($client, 1024);
    
    // --- PREPARE JSON RESPONSE ---
    // Create a PHP array with data to send as JSON
    $data = [
        'message' => 'Hello from PHP!',      // A simple message
        'status' => 'success',               // Status indicator
        'timestamp' => time(),               // Unix timestamp (seconds since 1970)
        'date' => date('Y-m-d H:i:s')        // Formatted date and time
    ];
    
    // Convert PHP array to JSON string
    // JSON_PRETTY_PRINT adds indentation and line breaks for readability
    // Without this flag, the JSON would be a single line
    $json = json_encode($data, JSON_PRETTY_PRINT);
    
    // --- CREATE HTTP RESPONSE ---
    // Build the HTTP response with proper headers
    // HTTP/1.1 200 OK - Status line indicating successful response
    $response = "HTTP/1.1 200 OK\r\n";
    // Content-Type - Tells the client this is JSON data
    $response .= "Content-Type: application/json\r\n";
    // Content-Length - Size of response body in bytes (required for HTTP/1.1)
    $response .= "Content-Length: " . strlen($json) . "\r\n";
    // Connection: close - Tells client to close the connection after this response
    $response .= "Connection: close\r\n\r\n";  // Double \r\n marks end of headers
    
    // Append the JSON data after the headers
    $response .= $json;
    
    // --- SEND RESPONSE ---
    // Write the complete HTTP response to the client socket
    socket_write($client, $response, strlen($response));
    
    // --- CLOSE CLIENT CONNECTION ---
    // Close this specific client connection
    // This frees up system resources
    socket_close($client);
    
    // --- LOG REQUEST ---
    // Output a message to the server console for logging purposes
    echo "Request handled\n";
}

// --- CLEANUP ---
// Close the main server socket
// Note: This line will never execute in this example
// because the while loop runs forever
// You would need to implement a proper shutdown mechanism
socket_close($socket);
