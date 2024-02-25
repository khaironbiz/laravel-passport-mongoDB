<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::findOrFail($this->id_pasien);
        $petugas = User::findOrFail($this->id_petugas);
        return [
            'id'        => $this->id,
            'value'     => $this->value,
            'unit'      => $this->unit,
            'coding'    => $this->coding,
            'time'      => $this->time,
            'base_line' => $this->base_line,
            'interpretation' => $this->interpretation,
            'pasien'    => [
                'id'    => $this->id_pasien,
                'nik'   => $user->nik,
                'nama'  => $user->nama
            ],
            'petugas'    => [
                'id'    => $petugas->_id,
                'nik'   => $petugas->nik,
                'nama'  => $petugas->nama
            ],

        ];
    }
}
