<?php

namespace App\Http\Requests\CalendarEvents;

use Illuminate\Foundation\Http\FormRequest;

class AddEventRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|after_or_equal:start_date',
            'days' => 'required|array',
            'days.*' => 'integer|min:0|max:6'
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'Event name is required.',
            'days.required' => 'Select at least 1 day of the week',
            'days.*.*' => 'Invalid day of the week.'
        ];
    }
}
