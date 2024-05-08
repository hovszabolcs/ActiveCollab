<?php

namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigView extends HtmlView
{
    protected static Environment $twig;

    public static function init() {
        $loader = new FilesystemLoader(TEMPLATE_DIR);
        static::$twig = new Environment($loader, [
            'cache' => DEBUG ? false : TEMPLATE_CACHE_DIR
        ]);
        static::extendTwigFunctions();
    }

    public function __construct(array $params = [])
    {
        parent::__construct($params);

        if (!isset(static::$twig))
            static::init();
    }

    public function render(): void {
        if (!$this->getTemplate()) {
            $this->sendHeaders();
            return;
        }

        $this->sendHeaders();
        echo static::$twig->render($this->getTemplate(), $this->getParams());
    }

    protected static function extendTwigFunctions() {
        $twig = static::$twig;

        $twig->addFunction(function: new TwigFunction('asset', ));

        $twig->addFunction(new TwigFunction('old', function(string $key, $default = null) {
            return TwigView::getOldData($key, $default);
        }));

        $twig->addFunction(new TwigFunction('error', function(string $key) {
            return TwigView::getError($key);
        }));
    }

}