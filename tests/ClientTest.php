<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
      protected function tearDown()
      {
        Stylist::deleteAll();
        Client::deleteAll();
      }

      function testGetClientName()
      {
        $client_name = "Meredith Alcorn";
        $stylist_id = 1;
        $test_client = new Client($client_name, $stylist_id);

        $result = $test_client->getClientName();

        $this->assertEquals($client_name, $result);
      }

      function testGetId()
      {
        $stylist_name = "Jesse Thacker";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();

        $id = 1;
        $client_name = "Meredith Alcorn";
        $test_client = new Client($client_name, $stylist_id, $id);

        $result = $test_client->getId();

        $this->assertEquals($id, $result);
      }

      function testGetStylistId()
      {
        $stylist_name = "Stylin Douglas";
        $id = null;
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();

        $client_name = "Meredith";
        $test_client = new Client($client_name, $stylist_id);

        $result = $test_client->getStylistId();

        $this->assertEquals($stylist_id, $result);
      }

      function testSave()
      {
        $stylist_name = "Stylin Douglas";
        $id = null;
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();

        $client_name = "Meredith Alcorn";
        $test_client = new Client($client_name, $stylist_id);
        $test_client->save();

        $result = Client::getAll();

        $this->assertEquals($test_client, $result[0]);
      }

      function testGetAll()
      {
        $stylist_name = "Stylin Douglas";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();

        $client_name = "Meredith Alcorn";
        $client_name2 = "Hank Dasket";
        $test_client = new Client($client_name, $stylist_id);
        $test_client->save();
        $test_client2 = new Client($client_name2, $stylist_id);
        $test_client2->save();

        $result = Client::getAll();

        $this->assertEquals([$test_client, $test_client2], $result);
      }

      function testDeleteAll()
      {
        $client_name = "Meredith Alcorn";
        $stylist_id = 2;
        $client_name2 = "Hank Dasket";
        $stylist_id = 1;
        $test_client = new Client($client_name, $stylist_id);
        $test_client->save();
        $test_client2 = new Client($client_name2, $stylist_id);
        $test_client2->save();

        Client::deleteAll();
        $result = Client::getAll();

        $this->assertEquals($result, []);
      }

      function testFindClientId()
      {
        $stylist_name = "Stylin Douglas";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();

        $client_name = "Meredith Alcorn";
        $client_name2 = "Hank Dasket";
        $test_client = new Client ($client_name, $stylist_id);
        $test_client->save();
        $test_client2 = new Client ($client_name2, $stylist_id);
        $test_client2->save();

        $result = Client::find($test_client->getId());

        $this->assertEquals($test_client, $result);
      }

      function testUpdate()
      {
        $client_name = "Meredith Alcorn";
        $id = null;
        $test_client = new Client ($client_name, $id);

        $new_name = "Meredith Grey";

        $test_client->update($new_name);

        $this->assertEquals("Meredith Grey", $test_client->getClientName());
      }

      function testDelete()
      {
        //Arrange
        $stylist_name = "Jesse Thacker";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();

        $stylist_name2 = "Stylin Douglas";
        $test_stylist2 = new Stylist($stylist_name2);
        $test_stylist2->save();
        $stylist_id2 = $test_stylist2->getId();

        $client_name = "Kendra Franklin";
        $id = null;
        $test_client = new Client($client_name, $stylist_id, $id);
        $test_client->save();

        $client_name2 = "Hank Dasket";
        $test_client2 = new Client($client_name2, $stylist_id2, $id);
        $test_client2->save();

        //Act
        $test_client->delete();

        //Assert
        $this->assertEquals([$test_client2], Client::getAll());
      }

    }






 ?>
