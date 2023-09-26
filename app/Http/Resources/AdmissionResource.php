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
        $user = User::find($this->id_pasien);
        $customer = Customer::find($this->id_faskes);
        return [
            'id'            => $this->_id,
            'nama_depan'    => $user->nama['nama_depan'],
            'nama_belakang' => $user->nama['nama_belakang'],
            'nama_faskes'   => $customer->name,
            'date'          => $this->date,
            'jaminan'       => $this->jaminan
        ];
    }
}
