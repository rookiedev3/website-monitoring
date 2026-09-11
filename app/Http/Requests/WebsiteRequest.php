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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Ambil ID dari route parameter 'website' (mendukung berupa Model Instance maupun ID Integer)
        $website = $this->route('website');
        $websiteId = is_object($website) ? $website->id : $website;

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

    /**
     * Custom message for validation errors.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama customer / perusahaan wajib diisi.',
            'website_name.required' => 'Nama / label project wajib diisi.',
            'url.required' => 'Domain / URL website wajib diisi.',
            'url.url' => 'Format URL tidak valid, contoh: https://client-one.com',
            'url.unique' => 'URL ini sudah terdaftar di sistem pemantauan.',
            'check_interval.required' => 'Interval pengecekan wajib diisi.',
            'check_interval.integer' => 'Interval pengecekan harus berupa angka.',
            'check_interval.min' => 'Interval pengecekan minimal 1 menit.',
            'check_interval.max' => 'Interval pengecekan maksimal 1440 menit (24 jam).',
            'timeout_seconds.required' => 'Timeout request wajib diisi.',
            'timeout_seconds.integer' => 'Timeout request harus berupa angka.',
            'timeout_seconds.min' => 'Timeout request minimal 1 detik.',
            'timeout_seconds.max' => 'Timeout request maksimal 60 detik.',
            'monitoring_status.required' => 'Status monitoring wajib dipilih.',
            'monitoring_status.in' => 'Pilihan status monitoring tidak valid.',
        ];
    }
}
