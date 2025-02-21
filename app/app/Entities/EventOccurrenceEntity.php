<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EventOccurrenceEntity extends Entity
{
    protected $attributes = [
        'id'                   => null,
        'event_id'         => null,
        'occurrence_date'  => null,
        'location'         => null,
        'image'   => null,
    ];
}
