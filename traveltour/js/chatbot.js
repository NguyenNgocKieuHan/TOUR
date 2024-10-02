document.addEventListener('DOMContentLoaded', function () {
    const chatboxBody = document.getElementById('chatbox-body');
    const sendMessageButton = document.getElementById('send-message');
    const userMessageInput = document.getElementById('user-message');

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message');
        messageDiv.classList.add(sender);
        messageDiv.textContent = text;
        chatboxBody.appendChild(messageDiv);
        chatboxBody.scrollTop = chatboxBody.scrollHeight;
    }

    sendMessageButton.addEventListener('click', function () {
        const userMessage = userMessageInput.value.trim();
        if (userMessage) {
            addMessage(userMessage, 'user');
            userMessageInput.value = '';

            // Send the message to the server for processing
            fetch('process_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'message=' + encodeURIComponent(userMessage)
            })
            .then(response => response.json())
            .then(data => {
                addMessage(data.response, 'bot');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });

    userMessageInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendMessageButton.click();
        }
    });
});
