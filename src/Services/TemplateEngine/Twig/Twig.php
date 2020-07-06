<?php


namespace App\Services\TemplateEngine\Twig;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../../../public/html/twig');
        $this->twig = new Environment($loader, []);
    }

    public function render($name, array $context = []): string
    {
        return $this->twig->render($name,$context);
    }
}