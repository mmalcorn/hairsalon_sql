<?php

  class Stylist
  {
    private $name;

    function __construct($name)

    {
      $this->name = $name;
      // $this->id = $id;
    }

    function getName()
    {
      return $this->name;
    }

    function setName($new_stylist)
    {
      $this->name = (string) $new_stylist;
    }

    // function getId()
    // {
    //   return $this->id;
    // }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO stylist (name) VALUES('{$this->getName()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
      $database_stylist = $GLOBALS['DB']->query("SELECT * FROM stylist;");
      $stylists = array();
      foreach($database_stylist as $stylist)
      {
        $name = $stylist['name'];
        $id = $stylist['id'];
        $new_stylist = new Stylist($name, $id);
        array_push($stylists, $new_stylist);
      }
        return $stylists;
      }
    //   if ($database_data)
    //   {
    //     $database_stylist = $database_data->fetchAll();
    //
    //     for ($stylist_index = 0; $stylist_index < count($database_stylist); $stylist_index++)
    //     {
    //       $name = $database_stylist[$stylist_index]['name'];
    //       $id = $database_stylist[$stylist_index]['id'];
    //       $new_stylist = new Stylist($name, $id);
    //       $stylists[] = $new_stylist;
    //     }
    //     return $stylists;
    // }
  //
    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM stylist;");
    }
  }

 ?>
