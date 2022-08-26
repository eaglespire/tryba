<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'serviceType' => $this->serviceType(),
            'kyc_status' => $this->kyc_status,
            'kyc_verif_status' => $this->kyc_verif_status,
            'verif_details_submitted' => $this->verif_details_submitted,
            'documents' => $this->documents,
            'accounts' => [
                'EUR' => $this->euroAccount(),
                'GBP' => $this->gBPAccount(),
            ],
        ];
    }
}
