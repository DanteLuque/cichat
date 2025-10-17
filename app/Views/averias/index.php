<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Averías</title>
</head>

<body>
  <div class="container mt-3">
    <a href="/averias/registrar" class="btn btn-primary mb-3">Crear Avería</a>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombres</th>
          <th>Problema</th>
          <th>Fecha y Hora</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="tablaAverias">
        <?php foreach ($averias as $averia): ?>
          <tr>
            <td><?= $averia['id'] ?></td>
            <td><?= $averia['nombres'] ?></td>
            <td><?= $averia['problema'] ?></td>
            <td><?= $averia['fechahora'] ?></td>
            <td><?= $averia['status'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    const conn = new WebSocket("ws://127.0.0.1:8080"); //ws
    conn.onopen = () => console.log("Conectado al WS");

    conn.onmessage = (event) => {
      const data = JSON.parse(event.data);
      console.log("Mensaje WS recibido:", data);

      if (data.type === "nueva_averia") {
        const averia = data.averia;
        agregarAveriaTabla(averia);
      }
    };

    function agregarAveriaTabla(averia) {
      const tbody = document.getElementById("tablaAverias");
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${averia.id}</td>
        <td>${averia.nombres}</td>
        <td>${averia.problema}</td>
        <td>${averia.fechahora}</td>
        <td>${averia.status}</td>
      `;
      tbody.append(tr);
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>
</body>

</html>