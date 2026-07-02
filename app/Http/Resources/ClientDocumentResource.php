<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'id' => $this->id,

            'client_id' => $this->client_id,

            'document_type' => $this->document_type,

            'document_name' => $this->document_name,

            'document_number' => $this->document_number,

            /*
            |--------------------------------------------------------------------------
            | File Information
            |--------------------------------------------------------------------------
            */

            'file_name' => $this->file_name,

            'original_file_name' => $this->original_file_name,

            'file_path' => $this->file_path,

            'file_url' => $this->file_url,

            'mime_type' => $this->mime_type,

            'file_size' => $this->file_size,

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            'issue_date' => $this->issue_date,

            'expiry_date' => $this->expiry_date,

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            'verification_status' => $this->verification_status,

            'verified_by' => $this->verified_by,

            'verified_at' => $this->verified_at,

            /*
            |--------------------------------------------------------------------------
            | Flags
            |--------------------------------------------------------------------------
            */

            'is_required' => $this->is_required,

            'is_active' => $this->is_active,

            'is_expired' => $this->is_expired,

            'is_expiring_soon' => $this->is_expiring_soon,

            /*
            |--------------------------------------------------------------------------
            | Additional Information
            |--------------------------------------------------------------------------
            */

            'remarks' => $this->remarks,

            'metadata' => $this->metadata,

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            'client' => $this->whenLoaded('client', function () {
                return [
                    'id' => $this->client->id,
                    'client_code' => $this->client->client_code,
                    'company_name' => $this->client->company_name,
                ];
            }),

            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator->id,
                    'name' => $this->creator->name,
                ];
            }),

            'verifier' => $this->whenLoaded('verifier', function () {
                return [
                    'id' => $this->verifier->id,
                    'name' => $this->verifier->name,
                ];
            }),

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

            /*
            |--------------------------------------------------------------------------
            | API Links
            |--------------------------------------------------------------------------
            */

            'links' => [

                'self' => route(
                    'client-documents.show',
                    $this->id
                ),

                'download' => route(
                    'client-documents.download',
                    $this->id
                ),

            ],

        ];
    }
}