<?php

namespace App\Models;

use \PDO;

class SqlConnect {
  public object $db;
  private string $host;
  private string $port;
  private string $dbname;
  private string $password;
  private string $user;

  public function __construct() {
    $this->host = 'localhost';
    $this->port = '3306';
    $this->dbname = 'app_event';
    $this->user = 'marco';
    $this->password = 'marco';

    $this->db = new PDO(
      'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
      $this->user,
      $this->password
    );

    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->db->setAttribute(PDO::ATTR_PERSISTENT, false);
  }

  public function transformDataInDot($data) {
    $dataFormated = [];

    foreach ($data as $key => $value) {
      $dataFormated[':' . $key] = $value;
    }

    return $dataFormated;
  }
}
