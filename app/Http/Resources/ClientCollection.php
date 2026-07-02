<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ClientResource::collection($this->collection),
        ];
    }

    /**
     * Additional meta information.
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,

            'message' => 'Clients fetched successfully.',

            'meta' => [

                'total' => $this->collection->count(),

                'generated_at' => now()->toDateTimeString(),

                'api_version' => '1.0',

            ],
        ];
    }

    /**
     * Customize pagination information.
     */
    public function paginationInformation(
        $request,
        $paginated,
        $default
    ): array {

        $default['meta']['api_version'] = '1.0';

        $default['meta']['generated_at'] = now()->toDateTimeString();

        return $default;
    }
}