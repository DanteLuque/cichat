<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>averias</title>
</head>

<body>
  <div class="container">
    <a href="/averias" class="btn btn-secondary mt-3 mb-3">Volver</a>
    <form id="formAveria">
      <div class="mb-3">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" class="form-control" id="nombres" name="nombres" required>
      </div>
      <div class="mb-3">
        <label for="problema" class="form-label">Problema</label>
        <textarea class="form-control" id="problema" name="problema" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="fechahora" class="form-label">Fecha y Hora</label>
        <input type="datetime-local" class="form-control" id="fechahora" name="fechahora" required>
      </div>
      <button type="submit" class="btn btn-primary">Registrar Averia</button>
    </form>
  </div>

  <script>
    const ws = new WebSocket("ws://127.0.0.1:8080");
    ws.onopen = () => console.log("Conectado al WS");

    document.getElementById("formAveria").addEventListener("submit", async function (e) {
      e.preventDefault();
      const averia = {
        nombres: document.getElementById("nombres").value,
        problema: document.getElementById("problema").value,
        fechahora: document.getElementById("fechahora").value
      };

      const res = await fetch("/api/averias/save", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(averia)
      });

      const data = await res.json();
      if (data.success) {
        ws.send(JSON.stringify({
          type: "nueva_averia",
          averia: data.averia
        }));

        document.getElementById("formAveria").reset();
      } else {
        alert("Error al registrar la avería");
      }
    });
  </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
  integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
  integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>

</html>