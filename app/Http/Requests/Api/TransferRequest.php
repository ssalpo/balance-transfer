<?php

namespace App\Http\Requests\Api;


use App\Http\Requests\Api\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'amount' => 'required'
        ];

        if (
            $this->request->has('receiver_id') ||
            ($this->request->has('email') && $this->request->has('receiver_id')) ||
            (!$this->request->has('email') && !$this->request->has('receiver_id'))
        ) {
            $rules['receiver_id'] = 'required';
        } else {
            $rules['email'] = 'required|email';
        }

        return $rules;
    }
}
