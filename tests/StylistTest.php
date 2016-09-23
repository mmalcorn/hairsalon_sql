<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class StylistTest extends PHPUnit_Framework_TestCase
    {

        function testGetName()
        {
            //Arrange
            $name = "Jesse Thacker";
            $test_stylist = new Stylist($name);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testGetId()
        {
          //Arrange
          $id = 1;
          $name = "Jesse Thacker";
          $test_stylist = new Stylist($name, $id);

          //Act
          $result = $test_stylist->getId();

          //Assert
          $this->assertEquals($id, $result);
        }
    }
?>
