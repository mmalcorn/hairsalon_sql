<?php

  class Stylist
  {
      private $name;
      private $id;

      function __construct($name, $id=null)

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
        $this->name = $new_stylist;
      }

      function getId()
      {
        return $this->id;
      }


  }

 ?>
