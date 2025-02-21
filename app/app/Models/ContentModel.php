<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class ContentModel extends Model
{
    protected $table = 'page_contents';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'page_id',
        'content_text',
        'content_image',
    ];
}
