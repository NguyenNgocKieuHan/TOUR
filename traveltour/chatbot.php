<?php
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="styles/chatbot.css">
</head>

<body>
    <div class="chatbox">
        <div class="chatbox-header">
            <h4>Chatbot</h4>
        </div>
        <div class="chatbox-body" id="chatbox-body">
            <!-- Messages will be dynamically added here -->
        </div>
        <div class="chatbox-footer">
            <input type="text" id="user-message" placeholder="Nhập tin nhắn..." />
            <button id="send-message">Gửi</button>
        </div>
    </div>

    <script src="js/chatbot.js"></script>
</body>

</html>