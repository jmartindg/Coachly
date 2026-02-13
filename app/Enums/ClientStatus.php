<?php

namespace App\Enums;

enum ClientStatus: string
{
    case Lead = 'lead';
    case Pending = 'pending';
    case Applied = 'applied';
    case Finished = 'finished';
}
