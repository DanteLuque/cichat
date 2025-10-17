<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>cichat</title>
</head>

<style>
  .message {
    margin: 1rem 0rem;
    max-width: 70%;
    border-radius: 18px;
    box-shadow: 0 2px 5px 0px gray;
    padding: 1rem;
  }

  .message-user {
    background-color: #d1e7dd;
    margin-left: auto;
  }

  .message-system {
    color: gray font-style: italic;
    font-size: 0.75rem;
  }

  .header{
    font-weight: bold;
    color: dodgerblue;
  }

  .time{
    font-size: 0.7rem;
    color: gray;
    text-align: right;
  }

  #chat-container {
    height: 100vh;
    border: 1px solid #ccc;
    padding: 1rem;
    border-radius: 10px;
    overflow-y: auto;
  }
</style>

<body>

  <div class="container">
    <div id="chat-header">
      <h4>Chat en tiempo real</h4>
      <div>
        <span id="statusText">Desconectado</span>
      </div>
    </div>
    <div id="chat-container">
      <div class="card border-0">
        <div class="card-body">
          <div id="chat-messages">
          </div>
        </div>
      </div>
    </div>

    <div id="chat-input">
      <div class="mb-2">
        <input type="text" name="userName" id="userName" placeholder="Nombre" class="form-control" autofocus>
      </div>
      <div class="mb-2">
        <div class="input-group">
          <input type="text" name="messageInput" id="messageInput" placeholder="tu mensaje" class="form-control">
          <button class="btn btn-success" type="button" id="sendButton">Enviar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>

  <script>
    let conn = null;
    const chatContainer = document.getElementById('chat-container');
    const messageInput = document.getElementById('messageInput');
    const usernameInput = document.getElementById('userName');
    const sendButton = document.getElementById('sendButton');
    const chatMessages = document.getElementById('chat-messages');
    const statusText = document.getElementById('statusText');

    function connect() {
      conn = new WebSocket('ws://127.0.0.1:8080');
      conn.onopen = function (e) {
        console.log("Conectado al servidor");
        statusText.textContent = "Conectado";
        addSystemMessage("Conectado al servidor");
      };

      conn.onmessage = function (e) {
        console.log("Mensaje recibido: " + e.data);
        const data = JSON.parse(e.data);
        if (data.type === 'system') {
          addSystemMessage(data.message);
        } else if (data.type === 'message') {
          addMessage(data);
        }
      };

      conn.onclose = function (e) {
        console.log("Desconectado del servidor");
        statusText.textContent = "Desconectado";
        addSystemMessage("Desconectado del servidor, reconectando...");

        setTimeout(connect, 3000);
      };

      conn.onerror = function (e) {
        console.log("Error: " + e.message);
      };
    }

    function sendMessage() {
      const message = messageInput.value.trim();
      const username = usernameInput.value.trim();

      if (message && conn.readyState === WebSocket.OPEN) {
        const data = {
          message: message,
          username: username,
        }
        conn.send(JSON.stringify(data));
        messageInput.value = '';
      }
    }

    function addSystemMessage(text) {
      const messageDiv = document.createElement('div');
      messageDiv.textContent = text;
      messageDiv.classList.add('message-system');
      chatMessages.appendChild(messageDiv);
      scrollToBottom();
    }

    function addMessage(data) {
      const messageDiv = document.createElement('div');
      const isCurrentUser = data.username === usernameInput.value.trim();

      const contentDiv = document.createElement('div');
      contentDiv.classList.add('message');

      if (!isCurrentUser) {
        const headerDiv = document.createElement('div');
        headerDiv.textContent = data.username;
        headerDiv.classList.add('header');
        contentDiv.appendChild(headerDiv);
      } else {
        contentDiv.classList.add('message-user');
      }

      const textDiv = document.createElement('div');
      textDiv.textContent = data.message;
      contentDiv.appendChild(textDiv);

      const timeDiv = document.createElement('div');
      timeDiv.textContent = data.timestamp;
      timeDiv.classList.add('time');
      contentDiv.appendChild(timeDiv);

      messageDiv.appendChild(contentDiv);
      chatMessages.appendChild(messageDiv);
      scrollToBottom();
    }

    function scrollToBottom() {
      chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    sendButton.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        sendMessage();
      }
    });

    connect();
  </script>
</body>

</html>