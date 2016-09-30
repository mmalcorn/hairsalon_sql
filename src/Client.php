<?php

  class Client
  {
    private $client_name;
    private $client_id;


    function __construct($client_name, $client_id = null)
    {
      $this->client_name = $client_name;
      $this->client_id = $client_id;
    }

    function getClientName()
    {
      return $this->client_name;
    }

    function setName($new_client)
    {
      $this->client_name = (string) $new_client;
    }

    function getClientId()
    {
      return $this->client_id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO clients (client_name) VALUES ('{$this->getClientName()}');");
      $this->client_id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
      $database_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
      $add_clients = array();
      foreach($database_clients as $client) {
        $client_name = $client['client_name'];
        var_dump($client_name);
        $client_id = $client['id'];
        var_dump($client_id);
        $new_client = new Client($client_name, $client_id);
        array_push($add_clients, $new_client);
      }
        return $add_clients;
    }
    
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM clients;");
    }

    static function find($search_id)
    {
      $found_client = null;
      $clients = Client::getAll();
      foreach ($clients as $client) {
        $client_id = $client->getClientId();
        if ($client_id == $search_id) {
          $found_client = $client;
        }
        return $found_client;
      }
    }

  }

 ?>
