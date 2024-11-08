<x-app-layout>
    @section('title', 'Data Diri - ' . config('app.name'))
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Diri') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Diri untuk mulai membuat Janji Temu') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('patients.profile.update') }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf
        @method('PUT')

        <div>
            <x-label for="nik" :value="__('patients.nik.label')" />
            <x-input id="nik" type="number" name="nik" placeholder="{{ __('patients.nik.placeholder') }}"
                value="{{ old('nik') ?? $patient?->nik }}" autocomplete="nik" required />
            <x-error :value="$errors->get('nik')" />
        </div>

        <div>
            <x-label for="phone" :value="__('patients.phone.label')" />
            <x-input id="phone" type="number" name="phone" placeholder="{{ __('patients.phone.placeholder') }}"
                value="{{ old('phone') ?? $patient?->phone }}" autocomplete="phone" required />
            <x-error :value="$errors->get('phone')" />
        </div>

        <div>
            <x-label for="birth_place" :value="__('patients.birth_place.label')" />
            <x-input id="birth_place" type="text" name="birth_place"
                placeholder="{{ __('patients.birth_place.placeholder') }}"
                value="{{ old('birth_place') ?? $patient?->birth_place }}" required />
            <x-error :value="$errors->get('birth_place')" />
        </div>

        <div>
            <x-label for="birth_date" :value="__('patients.birth_date.label')" />
            <x-input id="birth_date" type="date" name="birth_date"
                placeholder="{{ __('patients.birth_date.placeholder') }}"
                value="{{ old('birth_date') ?? $patient?->birth_date->format('Y-m-d') }}" required />
            <x-error :value="$errors->get('birth_date')" />
        </div>

        <div>
            <x-label for="gender" :value="__('patients.gender.label')" />
            <x-select id="gender" name="gender" required>
                @foreach ($genders as $key => $value)
                    <option value="{{ $key }}" @if ($key == (old('gender') ?? $patient?->gender)) selected @endif>
                        {{ \Illuminate\Support\Str::title($value) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('gender')" />
        </div>

        <div>
            <x-label for="blood_type" :value="__('patients.blood_type.label')" />
            <x-select id="blood_type" name="blood_type" required>
                @foreach ($bloodTypes as $key => $value)
                    <option value="{{ $key }}" @if ($key == (old('blood_type') ?? $patient?->blood_type)) selected @endif>
                        {{ \Illuminate\Support\Str::title($value) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('blood_type')" />
        </div>


        <div class="col-span-full">
            <x-label for="address" :value="__('patients.address.label')" />
            <x-textarea id="address" name="address" placeholder="{{ __('patients.address.placeholder') }}"
                value="{{ old('address') ?? $patient?->address }}" required rows="3" />
            <x-error :value="$errors->get('address')" />
        </div>

        <div class="flex justify-end space-x-2 col-span-full">
            <x-button type="reset" variant="outline">
                {{ __('actions.reset') }}
            </x-button>

            <x-button type="submit" variant="primary">
                {{ __('actions.submit') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
