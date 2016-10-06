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
      return $app['twig']->render('stylists.html.twig', array(
        'stylists' => Stylist::getAll()));
    });

    $app->post("/stylists", function() use ($app) {
      $stylist = new Stylist($_POST['add_stylist']);
      $stylist->save();
      return $app['twig']->render('stylists.html.twig', array(
        'stylists' => Stylist::getAll()));
    });

    $app->get("/stylists/{stylist_id}", function($stylist_id) use ($app) {
      $current_stylist = Stylist::find($stylist_id);
      return $app['twig']->render('stylist.html.twig', array(
        'single_stylist' => $current_stylist
      ));
    });

//     $app->get("/courses/{course_id}", function($course_id) use($app) {
//     $current_course = Course::find($course_id);
//     return $app['twig']->render('course.html.twig', array(
//         'single_course' => $current_course,
//         'all_students' => Student::getAll(),
//         'students_in_this_course' => $current_course->getStudents()
//     ));
// });


    $app->post("/stylists/{stylist_id}", function($stylist_id) use ($app) {
        $current_stylist = Stylist::find($stylist_id);

        print("\n SEARCH ID:");
        var_dump($stylist_id);
        print("\n");

        print("\nfound stylist:\n");
        var_dump($current_stylist);
        print("\n");

        $all_clients = Client::getAll();
        $client_name = $_POST['add_client'];
        $new_client = new Client($client_name, $stylist_id);
        $new_client->save();
        return $app['twig']->render('stylist.html.twig', array('clients' => $all_clients , 'single_stylist' => $current_stylist, 'stylist_id' => $current_stylist->getId));
    });

    // Clients
    $app->get("/clients", function() use ($app) {
        return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll()));
    });

    // $app->post("/clients", function() use ($app) {
    //   $client_name = $_POST['add_client'];
    //   $stylist_id = $_POST['dropdown_stylist'];
    //   $new_client = new Client($client_name, $stylist_id);
    //   $new_client->save();
    //   return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll(), 'stylists' => Stylist::getAll()));
    // });


    return $app;
?>
