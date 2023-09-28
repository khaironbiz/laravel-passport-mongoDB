<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id'            => $this->_id,
            'nama_depan'    => $this->pasien['nama']['nama_depan'],
            'nama_belakang' => $this->pasien['nama']['nama_belakang'],
            'nama_faskes'   => $this->faskes['name'],
            'service'       => $this->service['name'],
            'date'          => $this->date,
            'jaminan'       => $this->jaminan
        ];
    }
}
