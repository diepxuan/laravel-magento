<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 21:02:38
 */

namespace Diepxuan\Magento\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $oauth_consumer_key
 * @property string $success_call_back
 */
class IdentityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'oauth_consumer_key' => 'required|string|max:32',
            'success_call_back'  => 'required|string|max:4096',
        ];
    }
}
