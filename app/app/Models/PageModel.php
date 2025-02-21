<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'title',
        'subtitle',
        'page_type'
    ];
}
