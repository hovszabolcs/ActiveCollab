<?php

namespace App\Controller;

use Core\Request\TypeEmail;
use Core\Request\TypeString;
use App\Helper\MessageType;
use Core\HtmlView;
use Core\RequestMethodEnum;
use Core\TwigView;

class AuthController extends AppController
{
    public function login() {
        if ($this->request->getMethod() === RequestMethodEnum::GET)
            return TwigView::Create('auth.html.twig');

        $validationResponse = $this->request->validatePostData(
            [
                'user'      => (new TypeEmail())->Required(),
                'password'  => (new TypeString())->Required()
            ]
        );

        if ($validationResponse->hasError()) {
            return TwigView::Create('auth.html.twig')->withFallback($validationResponse);
        }

        $client = $this->authService->login($validationResponse['user'], $validationResponse['password']);
        if (!$client) {
            $this->message(MessageType::Error, 'Wrong username or password');
            return $this->redirectToLogin();
        }

        return HtmlView::Redirect('/');
    }
    public function redirectToLogin() {
        return HtmlView::Redirect('/login');
    }
}