<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    protected $allowedFields = [
        'name',
        'description',
        'organizer_first_name',
        'organizer_last_name',
        'organizer_phone',
        'organizer_email',
        'slug',
        'shorturl',
        'qrcode',
        'social_links'
    ];
}
