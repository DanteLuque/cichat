<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>cichat</title>
</head>

<body>

  <div class="container">
    <div id="chat-header">
      <h4>Chat en tiempo real</h4>
      <div>
        <span id="statusText">Desconectado</span>
      </div>
    </div>
    <div class="card my-3">
      <div class="card-body">
        <div id="chat-messages">
          <div class="message">
            Conectando al servidor...
          </div>
        </div>
      </div>
    </div>

    <div id="chat-input">
      <div class="mb-2">
        <input type="text" name="user-name" id="user-name" placeholder="Nombre" class="form-control" autofocus>
      </div>
      <div class="mb-2">
        <div class="input-group">
          <input type="text" name="message" id="message" placeholder="tu mensaje" class="form-control">
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
    function connect() {
      const conn = new WebSocket('ws://127.0.0.1:8080');
      conn.onopen = function (e) {
        console.log("Conectado al servidor");
      };

      conn.onmessage = function (e) {
        console.log("Mensaje recibido: " + e.data);

      };

      conn.onclose = function (e) {
        console.log("Desconectado del servidor");
      };

      conn.onerror = function (e) {
        console.log("Error: " + e.message);
      };
    }
    
    connect();
  </script>
</body>

</html>