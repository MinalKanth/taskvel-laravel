<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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

            'client_code' => $this->client_code,

            'company_name' => $this->company_name,

            'business_type' => $this->business_type,

            'status' => $this->status,

            'is_active' => $this->is_active,

            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            'email' => $this->email,

            'phone' => $this->phone,

            'website' => $this->website,

            /*
            |--------------------------------------------------------------------------
            | Tax Information
            |--------------------------------------------------------------------------
            */

            'gstin' => $this->gstin,

            'pan' => $this->pan,

            'tan' => $this->tan,

            /*
            |--------------------------------------------------------------------------
            | Registration
            |--------------------------------------------------------------------------
            */

            'cin' => $this->cin,

            'udyam_number' => $this->udyam_number,

            'fssai_number' => $this->fssai_number,

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            'contacts' => ClientContactResource::collection(
                $this->whenLoaded('contacts')
            ),

            'addresses' => ClientAddressResource::collection(
                $this->whenLoaded('addresses')
            ),

            'documents' => ClientDocumentResource::collection(
                $this->whenLoaded('documents')
            ),

            'services' => ClientServiceResource::collection(
                $this->whenLoaded('services')
            ),

            'remarks' => ClientRemarkResource::collection(
                $this->whenLoaded('remarks')
            ),

            'communications' => ClientCommunicationResource::collection(
                $this->whenLoaded('communications')
            ),

            'credentials' => ClientCredentialResource::collection(
                $this->whenLoaded('credentials')
            ),

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            'statistics' => [

                'documents' => $this->whenCounted('documents'),

                'contacts' => $this->whenCounted('contacts'),

                'services' => $this->whenCounted('services'),

                'remarks' => $this->whenCounted('remarks'),

                'communications' => $this->whenCounted('communications'),

            ],

            /*
            |--------------------------------------------------------------------------
            | Links
            |--------------------------------------------------------------------------
            */

            'links' => [

                'self' => route('clients.show', $this->id),

                'edit' => route('clients.edit', $this->id),

            ],

        ];
    }
}