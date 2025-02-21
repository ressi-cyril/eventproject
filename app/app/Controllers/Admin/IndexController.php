<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        return view('admin/index');
    }
}