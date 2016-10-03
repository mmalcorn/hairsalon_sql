<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylists/{id}", function($id) use ($app) {
      $stylist = Stylist::find($id);
      return $app['twig']->render('stylists.html.twig', array('stylists' => $stylists, 'clients' => $stylist->getClientName()));
    });

    $app->get("/clients", function() use ($app) {
      return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll()));
    });

    $app->post("/stylists", function() use ($app) {
      $stylist = new Stylist ($_POST['add_stylist']);
      $stylist->save();
      return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/remove_stylists", function() use ($app) {
      Stylist::deleteAll();
      return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
