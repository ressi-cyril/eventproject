<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'event_id',
        'occurrence_id',
        'images',
        'gallery_type'
    ];
}
