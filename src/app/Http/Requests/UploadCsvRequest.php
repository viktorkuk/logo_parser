<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UploadCsvRequest extends FormRequest
{

    public function rules()
    {
        return [
            'csv_file' => [
                'required',
                'file',
                'mimes:csv,txt'
            ],
        ];
    }
}
