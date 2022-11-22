<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Proxy\App\Data\FormatEnum;

class ProxyExportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'format' => [
                'required',
                'string',
                Rule::in('ip:port@login:password', 'ip:port', 'ip', 'ip@login:password'),
            ],
        ];
    }

    public function formatValue(): FormatEnum
    {
        return FormatEnum::from($this->validated('format'));
    }
}