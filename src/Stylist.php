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
            return $found_stylist;
          }
      }
    }

 ?>
