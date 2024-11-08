<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    protected array $statuses = ['pending', 'confirmed', 'cancelled', 'finished'];
    protected array $hours;

    public function __construct()
    {
        $open = (int) env('APPOINTMENT_OPEN');
        $close = (int) env('APPOINTMENT_CLOSE');

        $this->hours = array_map(function ($hour) {
            return Carbon::createFromFormat('H:i', $hour . ':00')->format('H:i');
        }, range($open, $close));
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:today', 'before:+1 week'],
            'time' => ['required', 'date_format:H:i', Rule::in($this->hours)],
            'service_id' => ['required', 'string', Rule::exists('services', 'id')],
            'payment_id' => ['required', 'string', Rule::exists('payments', 'id')],
            'frequency' => ['required', 'string', Rule::in([
                'Kirim Notifikasi Melalui Email',
            ])],
        ];
    }

    /**
     * Set the attributes for localization.
     */
    public function attributes(): array
    {
        return [
            'date' => __('appointments.date.label'),
            'time' => __('appointments.time.label'),
            'service_id' => __('appointments.service_id.label'),
            'payment_id' => __('appointments.payment_id.label'),
            'frequency' => __('appointments.frequency.label'),
        ];
    }
}
