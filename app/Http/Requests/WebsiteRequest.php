<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebsiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $websiteId = $this->route('website')?->id ?? $this->route('website');

        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'website_name' => ['required', 'string', 'max:255'],
            'url' => [
                'required',
                'url',
                'max:255',
                Rule::unique('websites', 'url')->ignore($websiteId),
            ],
            'category' => ['nullable', 'string', 'max:255'],
            'check_interval' => ['required', 'integer', 'min:1', 'max:1440'],
            'timeout_seconds' => ['required', 'integer', 'min:1', 'max:60'],
            'monitoring_status' => ['required', Rule::in(['active', 'paused'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama customer / perusahaan wajib diisi.',
            'website_name.required' => 'Nama / label project wajib diisi.',
            'url.required' => 'Domain / URL website wajib diisi.',
            'url.url' => 'Format URL tidak valid, contoh: https://client-one.com',
            'url.unique' => 'URL ini sudah terdaftar di sistem pemantauan.',
            'check_interval.required' => 'Interval pengecekan wajib diisi.',
            'timeout_seconds.required' => 'Timeout request wajib diisi.',
            'monitoring_status.required' => 'Status monitoring wajib dipilih.',
        ];
    }
}
