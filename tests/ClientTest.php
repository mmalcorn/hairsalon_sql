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
        $test_client = new curl_multi_getcontent
        $stylist_id = 1;
        $test_client = new Client($client_name, $stylist_id);

        $result = $test_client->getClientName();

        $this->assertEquals($client_name, $result);
      }

      function testGetStylistId()
      {
        $client_name = "Meredith Alcorn";
        $test_client = new Client($client_name, $client_id, $stylist_id);
        $test_client->save();
        $stylist_id = $test_stylist->getId();

        $client_id = 1;
        $test_client = new Client($client_name, $client_id, $stylist_id);

        $result = $test_client->getClientId();

        $this->assertEquals($stylist_id, $result);
      }

      function testSave()
      {
        $client_name = "Meredith Alcorn";
        $stylist_id = 1;
        $test_client = new Client($client_name, $stylist_id);
        $test_client->save();

        $result = Client::getAll();

        $this->assertEquals($test_client, $result[0]);
      }

      function testGetAll()
      {
        $client_name = "Meredith Alcorn";
        $client_name2 = "Hank Dasket";
        $stylist_id = 1;
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

      function testGetClientId()
      {
        $client_name = "Meredith Alcorn";
        $client_name2 = "Hank Dasket";
        $stylist_id = 1;

        $test_client = new Client ($client_name, $stylist_id);
        $test_client->save();
        $test_client2 = new Client ($client_name2, $stylist_id);
        $test_client2->save();

        $result = Client::find($test_client->getClientId());

        $this->assertEquals($test_client, $result);
      }

    }






 ?>
