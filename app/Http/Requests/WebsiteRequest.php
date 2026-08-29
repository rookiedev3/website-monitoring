<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pembatasan Akses Khusus Super Admin
        return auth()->check() && auth()->user()->role === 'super_admin';
    }

    public function rules(): array
    {
        $websiteId = $this->route('website') ? $this->route('website')->id : null;

        return [
            'customer_name'     => 'required|string|max:255',
            'website_name'      => 'required|string|max:255',
            'url'               => 'required|url|unique:websites,url,' . $websiteId,
            'category'          => 'nullable|string|max:100',
            'monitoring_status' => 'required|in:active,paused',
            'check_interval'    => 'required|integer|min:1',
            'timeout_seconds'   => 'required|integer|min:1',
            'notes'             => 'nullable|string',
        ];
    }
}