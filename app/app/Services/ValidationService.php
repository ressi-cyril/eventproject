<?php

declare(strict_types=1);

namespace App\Services;

use CodeIgniter\Validation\ValidationInterface;
use Exception;

class ValidationService
{
    protected ValidationInterface $validation;

    public function __construct()
    {
        $this->validation = service('validation');
    }

    /**
     * Validate given datas with rules.
     * Throw exception if validation errors
     * @return void
     */
    public function  validate(array $datas, array $rules): void
    {
        $this->validation->setRules($rules);

        if (!$this->validation->run($datas)) {
            throw new Exception(json_encode($this->validation->getErrors()), 400);
        }
    }
}
