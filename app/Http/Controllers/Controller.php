<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function formatError(\Exception $e): array
    {
        return [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ];
    }
}
