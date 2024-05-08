<?php

namespace Core;

enum RequestMethodEnum: string {
    case GET = 'get';
    case POST = 'post';
    case PUT = 'put';
    case PATCH = 'patch';
    case DELETE = 'delete';
    case ANY = 'any';

}
