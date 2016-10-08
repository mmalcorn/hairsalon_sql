<?php

  class Client
  {
    private $client_name;
    private $stylist_id;
    private $id;

    function __construct($client_name, $stylist_id, $id = null)
    {
      $this->client_name = $client_name;
      $this->stylist_id = $stylist_id;
      $this->id = $id;
    }

    function getClientName()
    {
      return $this->client_name;
    }

    function setClientName($new_client)
    {
      $this->client_name = (string) $new_client;
    }

    function getId()
    {
      return $this->id;
    }

    function getStylistId()
    {
      return $this->stylist_id;
    }

    function setStylistId($new_stylist)
    {
      $this->stylist_id = (string) $new_stylist;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO clients (client_name, stylist_id) VALUES ('{$this->getClientName()}', {$this->getStylistId()});");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
      $database_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
      $all_clients = array();
      foreach($database_clients as $client) {
        $client_name = $client['client_name'];
        $stylist_id = $client['stylist_id'];
        $id = $client['id'];
        $new_client = new Client($client_name, $stylist_id, $id);
        array_push($all_clients, $new_client);
      }
        return $all_clients;
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
        $id = $client->getId();
        if ($id == $search_id) {
          $found_client = $client;
        }
      }
      return $found_client;
    }

    function update($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE clients SET client_name = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setClientName($new_name);
    }

    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM clients WHERE id ={$this->getId()};");
    }

  }

 ?>
