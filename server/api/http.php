<?php
// Save this file as "simple_server.php"

// Set server details - localhost (127.0.0.1) is only accessible from your computer
// Port 8000 is commonly used for development servers
$host = '127.0.0.1';
$port = 8000;

// Create a TCP/IP socket
// AF_INET - IPv4 Internet based protocols
// SOCK_STREAM - Provides sequenced, reliable, two-way, connection-based byte streams (TCP)
// SOL_TCP - Protocol level for TCP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Enable address reuse
// This allows the server to reuse the address if it was previously used
// Prevents "Address already in use" errors when restarting the server quickly
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

// Bind the socket to the specified IP address and port
// This assigns the address to the socket so it knows where to listen
socket_bind($socket, $host, $port);

// Start listening for connections
// This puts the socket into a passive mode where it waits for clients to connect
socket_listen($socket);

// Print server information to the console
echo "Server started at http://$host:$port\n";
echo "Press Ctrl+C to stop the server\n";

// Main server loop - this runs continuously until manually stopped
while (true) {
    // Accept an incoming connection
    // This creates a new socket specifically for this client
    // The original socket continues to listen for new connections
    $client = socket_accept($socket);
    
    // Read the client's HTTP request
    // 1024 bytes should be enough for basic HTTP headers
    $request = socket_read($client, 1024);
    
    // Create a simple HTML response
    // This HTML includes:
    // - DOCTYPE declaration (HTML5)
    // - Basic HTML structure with head and body
    // - A heading and paragraph
    // - Current server timestamp
    $html = "
    <!DOCTYPE html>
    <html>
    <head>
        <title>My PHP Server</title>
    </head>
    <body>
        <h1>Hello from PHP!</h1>
        <p>This is a simple HTTP server created with PHP.</p>
        <p>Current time: " . date('Y-m-d H:i:s') . "</p>
    </body>
    </html>";
    
    // Create HTTP headers
    // HTTP/1.1 200 OK - Response status line (protocol, status code, status message)
    // Content-Type - Tells the browser this is HTML content
    // Content-Length - Size of the response body in bytes (required for keep-alive connections)
    // Connection: close - Tells the client to close the connection after this response
    $response = "HTTP/1.1 200 OK\r\n";
    $response .= "Content-Type: text/html\r\n";
    $response .= "Content-Length: " . strlen($html) . "\r\n";
    $response .= "Connection: close\r\n\r\n";  // Note: Double \r\n marks end of headers
    
    // Append the HTML body to the headers
    $response .= $html;
    
    // Send the complete HTTP response to the client
    // This writes the data to the client socket
    socket_write($client, $response, strlen($response));
    
    // Close the client connection to free up resources
    // Each client gets its own socket that must be closed when done
    socket_close($client);
    
    // Output a message to the server console
    echo "Request handled\n";
}

// Close the main server socket
// Note: This line will never be reached in this example since the loop runs forever
// You would need to implement a proper shutdown mechanism to reach this point
socket_close($socket);
