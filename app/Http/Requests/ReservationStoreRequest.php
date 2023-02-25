<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ReservationStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'start_at' => 'required|date|after:now',
            'end_at'   => 'required|date|after:start_at'

        ];
    }

    public function messages()
    {
        return [
            'start_at.required' => '予約開始日は必須です',
            'start_at.after'    => '予約開始日は本日以降で入力してください',
            'end_at.required'   => '予約終了日は必須です',
            'end_at.after'      => '予約終了日は予約開始日以降で入力してください'
        ];
    }
}
