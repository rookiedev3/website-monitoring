<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebsiteRequest extends FormRequest
{
    /**
     * Sesuaikan otorisasi ini kalau nanti pakai policy/role tertentu.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Saat update, kolom unik (mis. url) tidak boleh bentrok dengan dirinya sendiri.
        $websiteId = $this->route('website')?->id;

        return [
            'customer_name'     => ['required', 'string', 'max:255'],
            'website_name'      => ['required', 'string', 'max:255'],
            'url'               => [
                'required',
                'url',
                'max:255',
                Rule::unique('websites', 'url')->ignore($websiteId),
            ],
            'category'          => ['required', 'string', Rule::in(['ecommerce', 'company', 'portal', 'webapp'])],
            'check_interval'    => ['required', 'integer', Rule::in([5, 10, 15, 30])],
            'pic'               => ['required', 'string', 'max:255'],
            'monitoring_status' => ['required', Rule::in(['active', 'paused'])],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required'     => 'Nama customer / perusahaan wajib diisi.',
            'website_name.required'      => 'Nama / label project wajib diisi.',
            'url.required'               => 'Domain / URL website wajib diisi.',
            'url.url'                    => 'Format URL tidak valid, contoh: https://client-one.com',
            'url.unique'                 => 'URL ini sudah terdaftar di sistem pemantauan.',
            'category.required'          => 'Kategori website wajib dipilih.',
            'check_interval.required'    => 'Interval pengecekan wajib dipilih.',
            'pic.required'               => 'Penanggung jawab (PIC internal) wajib diisi.',
            'monitoring_status.required' => 'Status monitoring awal wajib dipilih.',
        ];
    }
}