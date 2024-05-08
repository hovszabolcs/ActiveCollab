<?php

namespace App\Helper;

enum MessageType: string
{
    case Success = 'success';
    case Error = 'error';
    case Warning = 'warning';
    case Info = 'info';
    case Notice = 'notice';
}
