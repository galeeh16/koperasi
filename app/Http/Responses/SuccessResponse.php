<?php declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

final class SuccessResponse implements Responsable
{

    public function __construct(
        private string $message = 'Success',
        private mixed $data = null,
        private int $statusCode = 200
    )
    {
        //
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}
