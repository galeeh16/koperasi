<?php declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

final class ErrorResponse implements Responsable
{

    public function __construct(
        private string $message = 'Internal Server Error',
        private mixed $error = null,
        private int $statusCode = 500
    )
    {
        //
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message,
            'error' => $this->error,
        ], $this->statusCode);
    }
}
