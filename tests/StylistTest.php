<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class StylistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Stylist::deleteAll();
          Client::deleteAll();
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

        function testSave()
        {
          //Arrange
          $name = "Jesse Thacker";
          $test_stylist = new Stylist($name);
          $test_stylist->save();

          //Act
          $result = Stylist::getAll();

          //Assert
          $this->assertEquals($test_stylist, $result[0]);
        }

        function testGetAll()
        {
          //Arrange
          $id = 1;
          $name = "Jesse Thacker";
          $name2 = "Stylin Douglas";
          $test_stylist = new Stylist($name);
          $test_stylist->save();
          $test_stylist2 = new Stylist($name2);
          $test_stylist2->save();

          //Act
          $result = Stylist::getAll();

          //Assert
          $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function testDeleteAll()
        {
          //Arrange
          $name = "Jesse Thacker";
          $name2 = "Stylin Douglas";
          $test_stylist = new Stylist($name);
          $test_stylist->save();
          $test_stylist2 = new Stylist($name2);
          $test_stylist2->save();

          //Act
          Stylist::deleteAll();
          $result = Stylist::getAll();

          //Assert
          $this->assertEquals([], $result);
        }

        function testFindStylistId()
        {
          $name = "Jesse Thacker";
          $name2 = "Stylin Douglas";
          $test_stylist = new Stylist($name);
          $test_stylist->save();
          $test_stylist2 = new Stylist ($name2);
          $test_stylist2->save();

          $result = Stylist::find($test_stylist->getId());

          $this->assertEquals($test_stylist, $result);
        }

        function testGetClients()
        {
          //Arrange Stylists
          //Create Two Instances of Stylists and Test Respective Id's
          $stylist_name = "Jesse Thacker";
          $stylist_name2 = "Stylin Douglas";
          $test_stylist = new Stylist ($stylist_name);
          $test_stylist->save();
          $test_stylist_id = $test_stylist->getId();
          $test_stylist2 = new Stylist ($stylist_name2);
          $test_stylist2->save();
          $test_stylist_id2 = $test_stylist2->getId();

          //Arrange Clients
          //Create Two Instances of Clients and Set Them to A Stylist
          $client_name = "Meredith Alcorn";
          $test_client = new Client ($client_name, $test_stylist_id);
          $test_client->save();

          $client_name2 = "Pebbles Flintstone";
          $test_client2 = new Client ($client_name2, $test_stylist_id);
          $test_client2->save();

          $client_name3 = "Deuce Hedgepeth";
          $test_client3 = new Client ($client_name3, $test_stylist_id2);
          $test_client3->save();

          //Act
          $result = $test_stylist->getClients();

          //Assert
          $this->assertEquals([$test_client, $test_client2], $result);
        }

        function testUpdateStylist()
        {
          //Arrange
          $stylist_name = "Jesse Thacker";
          $id = null;
          $test_stylist = new Stylist ($stylist_name, $id);
          $test_stylist->save();

          $new_stylist_name = "Jesse Danish";

          //Act
          $test_stylist->update($new_stylist_name);

          $this->assertEquals("Jesse Danish", $test_stylist->getName());
        }

        function testDelete()
        {
          //Arrange
          $stylist_name = "Stylin Douglas";
          $id = null;
          $test_stylist = new Stylist($stylist_name, $id);
          $test_stylist->save();

          $stylist_name2 = "Jesse Thacker";
          $test_stylist2 = new Stylist($stylist_name2, $id);
          $test_stylist2->save();

          //Act
          $test_stylist->delete();

          //Assert
          $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function testDeleteStylistClients()
        {
          //Assert
          $stylist_name = "Jesse Thacker";
          $id = null;
          $test_stylist = new Stylist ($stylist_name, $id);
          $test_stylist->save();

          $client_name = "Meredith Alcorn";
          $stylist_id = $test_stylist->getId();
          $test_client = new Client ($client_name, $stylist_id);
          $test_client->save();

          //Act
          $test_client->delete();

          //Assert
          $this->assertEquals([], Client::getAll());
        }
    }
?>
