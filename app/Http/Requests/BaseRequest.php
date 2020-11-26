<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{

    public function __construct()
    {
        parent::__construct();
    }

    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [];
    }
}
