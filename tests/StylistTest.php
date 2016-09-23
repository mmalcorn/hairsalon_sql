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

        protected function tearDown()
        {
          Stylist::deleteAll();
        }

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

        // function testGetId()
        // {
        //   //Arrange
        //   $id = 1;
        //   $name = "Jesse Thacker";
        //   $test_stylist = new Stylist($name);
        //
        //   //Act
        //   $result = $test_stylist->getId();
        //
        //   //Assert
        //   $this->assertEquals($result);
        // }

        function testSave()
        {
          //Arrange
          $name = "Jesse Thacker";
          $test_stylist = new Stylist($name);

          //Act
          $test_stylist->save();

          //Assert
          $stylist_names = Stylist::getAll();
          $result = $stylist_names[0];
          $this->assertEquals($test_stylist, $result);
        }

        function testGetAll()
        {
          //Arrange
          $id = 1;
          $name = "Jesse Thacker";
          $name = "Stylin Douglas";
          $test_stylist = new Stylist($name);
          $test_stylist->save();
          $test_stylist1 = new Stylist($name);
          $test_stylist1->save();

          //Act
          $result = Stylist::getAll();

          //Assert
          $this->assertEquals([$test_stylist, $test_stylist1], $result);

        }
        //
        // function testDeleteAll()
        // {
        //   //Arrange
        //   $name = "Jesse Thacker";
        //   $name = "Stylin Douglas";
        //   $test_stylist = new Stylist($name);
        //   $test_stylist->save();
        //   $test_stylist1 = new Stylist($name);
        //   $test_stylist1->save();
        //
        //   //Act
        //   Stylist::deleteAll();
        //   $result = Stylist::getAll();
        //
        //   //Assert
        //   $this->assertEquals([], $result);
        // }
    }
?>
