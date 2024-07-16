<?php

namespace App\Http\Requests;

use App\Rules\NotFutureDate;
use App\Rules\NotOldTransaction;
use App\Traits\HandlesResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class TransactionRequest extends FormRequest
{
    use HandlesResponses;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'timestamp' => [
                'required',
                'date_format:Y-m-d\TH:i:s.v\Z',
                new NotFutureDate,
                new NotOldTransaction,
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (Arr::has($validator->failed(), 'timestamp.App\\Rules\\NotOldTransaction')) {
            abort($this->handleNoContentResponse());
        }

        abort($this->handleUnprocessableEntityResponse());
    }

    public function validateResolved()
    {
        if (! json_decode($this->getContent(), true)) {
            abort($this->handleBadRequestResponse());
        }

        parent::validateResolved();
    }
}
