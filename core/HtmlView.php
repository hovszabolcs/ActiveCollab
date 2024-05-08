<?php

namespace Core;

use Core\Request\ValidationResponse;

class HtmlView extends View {

    private array $headers = [];
    private ?string $template;


    public static function Create($template, $params = []): self {
        $self = new static($params);
        $self->setTemplate($template);
        return $self;
    }

    public static function Redirect($path): self {
        $self = new static([]);
        $self->addHeader(sprintf('Location: %s', $path));
        return $self;
    }

    public function __construct(array $params = []) {
        static::$params = array_merge(static::$params, $params);
    }

    public function setTemplate(string $template): static {
        $this->template = $template;
        return $this;
    }

    public function sendHeaders(): void {
        foreach($this->headers as $headerRow)
            header($headerRow);
    }

    public function addHeader($headerRow): self {
        $this->headers[] = $headerRow;
        return $this;
    }

    public function render(): void {
        $this->sendHeaders();
        // TODO: Render html (implemented in TwigView)
    }

    public function getTemplate(): ?string {
        return $this->template;
    }

    public function withFallback(ValidationResponse $response): static {
        View::setParam('__old', $response->getAllData());
        View::setParam('__error', $response->getErrors());
        return $this;
    }

    public static function getError(string $key): mixed {
        return static::$params['__error'][$key] ?? null;
    }

    public static function getOldData(string $key, $default = null): mixed {
        return static::$params['__old'][$key] ?? $default;
    }

}