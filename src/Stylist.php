<?php

    class Stylist
    {
        private $name;
        private $id;

        function __construct($name, $id = null)

        {
          $this->name = $name;
          $this->id = $id;
        }

        function getName()
        {
          return $this->name;
        }

        function setName($new_stylist)
        {
          $this->name = (string) $new_stylist;
        }

        function getId()
        {
          return $this->id;
        }

        function save()
        {
          $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_name) VALUES ('{$this->getName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
          $database_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
          $add_stylists = array();
          foreach($database_stylists as $stylist) {
            $name = $stylist['stylist_name'];
            $id = $stylist['id'];
            $new_stylist = new Stylist($name, $id);
            array_push($add_stylists, $new_stylist);
          }
            return $add_stylists;
         }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        static function find($search_id)
        {
          $found_stylist = null;
          $stylists = Stylist::getAll();
          foreach ($stylists as $stylist) {
            $stylist_id = $stylist->getId();
            if ($stylist_id == $search_id) {
              $found_stylist = $stylist;
            }
          }
          return $found_stylist;
      }

      function getClients()
      {
        $clients = array();
        $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()};");
        foreach ($returned_clients as $client) {
          $client_name = $client['client_name'];
          $id = $client['id'];
          $stylist_id = $client['stylist_id'];
          $new_client = new Client($client_name, $stylist_id, $id);
          array_push($clients, $new_client);
        }
          return $clients;
      }

      function update($new_name)
      {
        $GLOBALS['DB']->exec("UPDATE stylists SET stylist_name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
      }

      function delete()
      {
        $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
      }

    }

 ?>
