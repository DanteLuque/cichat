<?php

namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
  protected $clients;
  protected $users;

  public function __construct()
  {
    $this->clients = new \SplObjectStorage;
    $this->users = [];
  }

  public function onOpen(ConnectionInterface $conn)
  {
    // Almacenar la nueva conexión
    $this->clients->attach($conn);
    $this->users[$conn->resourceId] = $conn;

    echo "Nueva conexión! ({$conn->resourceId})\n";

    // Notificar a todos los clientes
    $this->broadcast([
      'type' => 'system',
      'message' => "Usuario #{$conn->resourceId} se ha conectado",
      'total_users' => count($this->users)
    ]);
  }

  public function onMessage(ConnectionInterface $from, $msg)
  {
    echo "Mensaje crudo recibido: $msg\n";
    $data = json_decode($msg, true);
    var_dump($data);

    $numRecv = count($this->clients) - 1;
    echo sprintf(
      'Conexión %d enviando mensaje "%s" a %d otro(s) cliente(s)' . "\n",
      $from->resourceId,
      $msg,
      $numRecv
    );

    $data = json_decode($msg, true);

    $response = [
      'type' => 'message',
      'user_id' => $from->resourceId,
      'message' => $data['message'] ?? $msg,
      'username' => $data['username'] ?? "Usuario {$from->resourceId}",
      'timestamp' => date('H:i:s')
    ];

    if ($data['type'] === 'nueva_averia') {
      foreach ($this->clients as $client) {
        $client->send(json_encode([
          'type' => 'nueva_averia',
          'averia' => $data['averia']
        ]));
      }
      return;
    }
    
    $this->broadcast($response);
  }

  public function onClose(ConnectionInterface $conn)
  {
    // La conexión se cerró, remover de la lista
    $this->clients->detach($conn);
    unset($this->users[$conn->resourceId]);

    echo "Conexión {$conn->resourceId} se ha desconectado\n";

    // Notificar a todos
    $this->broadcast([
      'type' => 'system',
      'message' => "Usuario #{$conn->resourceId} se ha desconectado",
      'total_users' => count($this->users)
    ]);
  }

  public function onError(ConnectionInterface $conn, \Exception $e)
  {
    echo "Error: {$e->getMessage()}\n";
    $conn->close();
  }

  /**
   * Enviar mensaje a todos los clientes
   */
  protected function broadcast($data, $exclude = null)
  {
    $message = json_encode($data);

    foreach ($this->clients as $client) {
      if ($exclude === null || $client !== $exclude) {
        $client->send($message);
      }
    }
  }
}