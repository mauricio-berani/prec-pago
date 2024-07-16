<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case SUCCESS = 'success';
    case EXPIRED = 'expired';
    case ERROR = 'error';
}
