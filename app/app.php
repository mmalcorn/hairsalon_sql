<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    //Stylists
    $app->get("/stylists", function() use ($app) {
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    // $app->post("/stylists", function() use ($app) {
    //   $stylist = new Stylist($_POST['add_stylist']);
    //   $stylist->save();
    //   return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    // });

    //clients
    $app->get("/clients", function() use ($app) {
        return $app['twig']->render('clients.html.twig');
    });

    $app->post("/clients", function() use ($app) {
      $client_name = $_POST['add_client'];
      $stylist_id = $_POST['dropdown_stylist'];
      $new_client = new Client($client_name, $stylist_id);
      $new_client->save();
      return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll(), 'stylists' => Stylist::getAll()));
    });


    return $app;
?>
