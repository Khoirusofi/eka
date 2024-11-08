<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromArray, WithHeadings
{
    protected Collection $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * array of data to export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->users->map(function (User $user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at->format('d F Y'),
                'updated_at' => $user->updated_at->format('d F Y'),
            ];
        })->toArray();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'role',
            'remember_token',
            'created_at',
            'updated_at'
        ];
    }
}
