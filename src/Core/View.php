<?php

namespace Core;

use Core\Interfaces\ViewInterface;
use \Twig_Loader_Filesystem;
use \Twig_Environment;


/**
 * Class View
 * @package Core
 */
class View implements ViewInterface
{

    protected $twig;

    /**
     * @var
     */
    private $file;


    /**
     * @var
     */
    private $title;

    public function __construct() {
        $loader = new Twig_Loader_Filesystem('../templates');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => false,
            'debug' => true,
        ));
        $this->twig->addExtension(new \Twig_Extension_Debug());
        $this->twig->addGlobal('_get', $_GET);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->getExtension(\Twig\Extension\CoreExtension::class)->setTimezone('Europe/Paris');
    }

    /**
     * @param $template
     * @param $path
     * @param array $data
     * @return false|string
     * @throws \Exception
     */
    public function render($template, $path, $data = [])
    {
        $this->file = '/'.$path.'/'.$template.'.html.twig';
        //$view = $this->renderFile($this->file, $data);
        //$view = $this->renderFile($this->file, ['title'=> $this->title, 'content'=> $content]);
        //var_dump($view);die();
        $view = $this->twig->render($this->file, $data);
        //var_dump($view);die();
        return $view;
    }


    /**
     * @param $file
     * @param $data
     * @return false|string
     * @throws \Exception
     */
    private function renderFile($file, $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new \Exception('Fichier vue inexistant');
        }

    }


    /**
     * @param $data
     * @return string
     */
    public function check($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
    }
}
