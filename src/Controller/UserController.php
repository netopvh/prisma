<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * UserController
 */
class UserController extends AppController
{

    /**
     * Index
     *
     * @return Response
     */
    public function indexPage(Request $request)
    {
        $this->initAction($request);
        $viewData = $this->getViewData($request);
        return $this->render('view::User/user-index.html.php', $viewData);
    }

    /**
     * Edit
     *
     * @param Request $request
     * @param Response $response
     * @param array|null $args
     * @return Response
     */
    public function editPage(Request $request, Response $response, array $args = null)
    {
        $this->initAction($request);

        //$request = request();
        //$response = response();

        // All GET parameters
        //$queryParams = $request->getQueryParams();

        // All POST or PUT parameters
        //$postParams = $request->getParsedBody();

        // Single GET parameter
        //$title = $queryParams['title'];
        //
        // Single POST/PUT parameter
        //$data = $postParams['data'];
        //
        // Get routing arguments
        //$attributes = $request->getAttributes();
        //$vars = $request->getAttribute('vars');
        $id = $args['id'];

        // Get config value
        //$env = config()->get('env');

        // Get GET parameter
        //$id = $queryParams['id'];

        // Increment counter
        $counter = $this->user->get('counter', 0);
        $counter++;
        $this->user->set('counter', $counter);

        $this->logger->info('My log message');

        // Set locale
        //$app->session->set('user.locale', 'de_DE');
        //
        //Model example
        //$user = new \App\Model\User($app);
        //$userRows = $user->getAll();
        //$userRow = $user->getById($id);
        //
        // Add data to template
        $viewData = $this->getViewData($request, [
            'id' => $id,
            'counter' => $counter,
            'assets' => $this->getAssets(),
        ]);

        // Render template
        return $this->render('view::User/user-edit.html.php', $viewData);
    }

    /**
     * Test page.
     *
     * @param array $args Arguments
     * @return Response Response
     */
    public function reviewPage(Request $request, Response $response, array $args = null)
    {
        $this->initAction($request);
        $id = $args['id'];
        $response->getBody()->write("Action: Show all reviews of user: $id<br>");
        return $response;
    }
}
