<?php

namespace App\Services\ActiveCollab;

use ActiveCollab\SDK\Authenticator\Cloud;
use ActiveCollab\SDK\Exception;
use ActiveCollab\SDK\Token;

class ActiveCollabAuthService
{
    public function login($email, $password): ?ActiveCollabClientService {
        try {
            $authenticator = new Cloud('API', 'API', $email, $password);
            $accounts = $authenticator->getAccounts();

            $account = reset($accounts); // TODO: handle multiple accounts
            return $this->makeClientInstance($authenticator->issueToken($account['id']));
        } catch (Exception $e) {
            return null;
        }
    }

    protected function makeClientInstance(Token $token) {
        return new ActiveCollabClientService($token);
    }

}