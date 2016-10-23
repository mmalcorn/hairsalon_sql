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

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    // Stylists (multiple)

    $app->get("/stylists", function() use ($app) {
      return $app['twig']->render('stylists.html.twig', array(
        'stylists' => Stylist::getAll()));
    });

    $app->post("/add_stylists", function() use ($app) {
      $stylist = new Stylist($_POST['add_stylist']);
      $stylist->save();
      return $app['twig']->render('stylists.html.twig', array(
        'stylists' => Stylist::getAll()));
    });

    $app->post("/delete_stylists", function() use($app) {
      Stylist::deleteAll();
      return $app['twig']->render('stylists.html.twig');
    });

    // Stylist (single)

    $app->get("/stylists/{stylist_id}", function($stylist_id) use ($app) {
      $current_stylist = Stylist::find($stylist_id);
      return $app['twig']->render('stylist.html.twig', array(
        'stylist' => $current_stylist,
        'clients' => $current_stylist->getClients()
      ));
    });

    // $app->post("/client_for_stylist", function() use ($app) {
    //   $client_name = $_POST['add_client_input'];
    //   $stylist_id = $_POST['stylist_id'];
    //   $stylist = Stylist::find($stylist_id);
    //   $new_client = new Client($client_name, $stylist_id);
    //   $new_client->save();
    //   return $app['twig']->render('stylist.html.twig', array(
    //     'single_stylist' => $stylist,
    //     'clients' => $stylist->getClients()
    //     ));
    // });

    // Edit Stylist

    $app->get("/stylists/{stylist_id}/edit", function($stylist_id) use ($app) {
      $stylist = Stylist::find($stylist_id);
      return $app['twig']->render("edit_stylist.html.twig", array(
        "stylist" => $stylist
      ));
    });

    $app->patch("/stylists/{stylist_id}", function($stylist_id) use ($app) {
      $stylist_name = $_POST["stylist_name"];
      $stylist = Stylist::find($stylist_id);
      $stylist->update($stylist_name);
      return $app['twig']->render("stylist.html.twig", array(
        "stylist" => $stylist,
        "clients" => $stylist->getClients()
      ));
    });

    $app->post("/stylists/{stylist_id}", function($stylist_id) use ($app) {
      $stylist = Stylist::find($stylist_id);
      $client = new Client($_POST["add_client_input"], $stylist_id);
      $client->save();
      return $app['twig']->render("stylist.html.twig", array(
        "stylist" => $stylist,
        "clients" => $stylist->getClients()
      ));
    });

    // Clients (multiple)

    $app->get("/clients", function() use ($app) {
        return $app['twig']->render('clients.html.twig', array(
          'clients' => Client::getAll(),
          'stylists' => Stylist::getAll()
        ));
    });

    $app->post("/add_new_client", function() use ($app) {
      $client_name = $_POST['client-name'];
      $stylist_id = $_POST['dropdown_stylist'];
      $new_client = new Client($client_name, $stylist_id);
      $new_client->save();
      return $app['twig']->render('clients.html.twig', array(
        'clients' => Client::getAll(),
        'stylists' => Stylist::getAll()
      ));
    });

    $app->post("/delete_clients", function() use ($app) {
      Client::deleteAll();
      return $app['twig']->render('clients.html.twig', array(
        'stylists' => Stylist::getAll()
      ));
    });

    // Client (single)

    $app->get("/clients/{client_id}", function($client_id) use ($app) {
        $current_client = Client::find($client_id);
        $stylist_id_for_client = $current_client->getStylistId();
        $client_stylist = Stylist::find($stylist_id_for_client);
        return $app['twig']->render('client.html.twig', array(
          'client' => $current_client,
          'stylist' => $client_stylist
        ));
    });

    $app->get("/clients/{client_id}/edit", function($client_id) use ($app) {
        $client = Client::find($client_id);
        return $app['twig']->render('edit_client.html.twig', array('clients' => $client
        ));
    });

    $app->patch("/clients/{client_id}", function($client_id) use ($app) {
      $client_name = $_POST['name'];
      $client = Client::find($client_id);
      $stylist_id_for_client = $client->getStylistId();
      $client_stylist = Stylist::find($stylist_id_for_client);
      $client->update($client_name);
      return $app['twig']->render('client.html.twig', array('client' => $client, 'stylist' => $client_stylist
      ));
    });

    $app->delete("/clients/{client_id}", function($client_id) use ($app) {
        $client_to_delete = Client::find($client_id);
        $client_to_delete->delete();
        return $app['twig']->render('clients.html.twig', array(
          'clients' => Client::getAll(),
          'stylists' => Stylist::getAll()
        ));
    });


    return $app;
?>
