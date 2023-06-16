<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // f_nam,  l_name, other_name, dob, joining_date, next_of_kin, next_of_kin_contact, education_level,
        // email, mobile_contact, home_contact
        return [
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'other_name' => $this->other_name,
            'email' => $this->email,
            'mobile_contact' => $this->mobile_contact,
            'home_contact' => $this->home_contact,
            'dob' => $this->dob,
            'joining_date' => $this->joining_date,
            'next_of_kin' => $this->next_of_kin,
            'next_of_kin_contact' => $this->next_of_kin_contact
        ];
    }
}
