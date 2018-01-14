<?php

namespace App\Controller;

use App\Service\User\AuthenticationService;
use Illuminate\Database\Connection;
use Interop\Container\Exception\ContainerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Container;
use Slim\Router;
use Slim\Views\Twig;
use Odan\Slim\Session\Session;

/**
 * AbstractController (Base class)
 */
abstract class AbstractController
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var AuthenticationService
     */
    protected $auth;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param Container $container
     * @throws ContainerException
     */
    public function __construct(Container $container)
    {
        $this->db = $container->get(Connection::class);
        $this->logger = $container->get(LoggerInterface::class);
        $this->router = $container->get('router');
        $this->auth = $container->get(AuthenticationService::class);
        $this->view = $container->get(Twig::class);
        $this->session = $container->get(Session::class);
    }

    /**
     * Returns default text.
     *
     * @return array Array with translated text
     */
    protected function getText(): array
    {
        $text = [];
        $text['Ok'] = __('Ok');
        $text['Cancel'] = __('Cancel');
        $text['Yes'] = __('Yes');
        $text['No'] = __('No');

        return $text;
    }

    /**
     * Get view data.
     *
     * @param array $viewData
     * @return array View data
     */
    protected function getViewData(array $viewData = []): array
    {
        $result = [
            'baseUrl' => $this->router->pathFor('root'),
            'text' => $this->getText()
        ];
        if (!empty($viewData)) {
            $result = array_replace_recursive($result, $viewData);
        }

        return $result;
    }

    /**
     * Render template.
     *
     * @param ResponseInterface $response
     * @param string $name Template file
     * @param array $viewData View data
     * @return ResponseInterface
     */
    protected function render(ResponseInterface $response, $name, array $viewData = []): ResponseInterface
    {
        return $this->view->render($response, $name, $viewData);
    }
}
