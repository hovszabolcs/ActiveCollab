<?php

namespace App\Services;

use Core\ConfigurationInterface;
use Predis\Client;

class RedisCache
{
    private Client $client;

    public function __construct(string $host = 'localhost', string $scheme = 'tcp', int $port = 6379) {
        $client = new Client('tcp://redis:6379');

        $this->client = $client;
        //$client->setex('test', 5, 'valami');
        $this->get('test', 20, function () {
            return 'value';
        });
    }

    public function get(string $key, int $sec, callable $callback): mixed {
        $client = $this->client;
        // TODO: Nem írja a session-t
        var_dump($_SESSION);
        $_SESSION['test'] = ['proba' => 10];
session_write_close();
        $lockKey = "test_lock";
        // $client->del("{$key}_lock");
        if ($client->setnx($lockKey, '1')) {
            $client->setex($key, 30, bin2hex(random_bytes(50)));
            $client->del($lockKey);
            var_dump('létrehozva');
            var_dump($client->get($key));
        }
        else {
            ob_start();
            var_dump($_GET);
            var_dump('Foglalt...');
            ob_end_flush();
            var_dump('SLEEP');
            while ($client->exists("{$key}_lock")) {
                sleep(1);
            }


            var_dump($client->get($key));
        }

        exit();


        $data = $callback($this);

    }
}