<?php

namespace App\Action;

use App\Service\User\Locale;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * LoginSubmitAction.
 */
class LoginSubmitAction extends AbstractAction
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * Constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->locale = $container->get(Locale::class);
    }

    /**
     * User login submit.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $data = (array)$request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

        $user = $this->auth->authenticate($username, $password);
        if (!empty($user)) {
            $this->locale->setLanguage($user->locale);
            $url = $this->router->pathFor('root');
        } else {
            $url = $this->router->pathFor('login');
        }

        return $response->withRedirect($url);
    }
}
