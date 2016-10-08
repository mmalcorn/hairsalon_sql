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
        'single_stylist' => $current_stylist,
        'clients' => Client::getAll()
      ));
    });

    $app->post("/client_for_stylist", function() use ($app) {
      $client_name = $_POST['add_client_input'];
      $stylist_id = $_POST['stylist_id'];
      $stylist = Stylist::find($stylist_id);
      $new_client = new Client($client_name, $stylist_id);
      $new_client->save();
      return $app['twig']->render('stylist.html.twig', array(
        'single_stylist' => $stylist,
        'clients' => Client::getAll()
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
      return $app['twig']->render('clients.html.twig');
    });


    return $app;
?>
