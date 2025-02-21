<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EventEntity extends Entity
{
    protected $attributes = [
        'id'                   => null,
        'name'                 => null,
        'description'          => null,
        'organizer_first_name' => null,
        'organizer_last_name'  => null,
        'organizer_phone'      => null,
        'organizer_email'      => null,
        'slug'                 => null,
        'shorturl'             => null,
        'qrcode'               => null,
        'social_links'         => null,
    ];
}
