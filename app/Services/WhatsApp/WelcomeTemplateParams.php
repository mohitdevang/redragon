<?php

namespace App\Services\WhatsApp;

use App\Models\User;
use App\Models\UserParent;
use App\Support\CountryDial;

class WelcomeTemplateParams
{
    /**
     * System-defined placeholders (position => field). Unmapped template positions stay empty.
     *
     * @return array<int, array{position: int, key: string, label: string, example: string}>
     */
    public static function definitions(): array
    {
        return [
            ['position' => 1, 'key' => 'name', 'label' => 'Full name', 'example' => 'John Doe'],
            ['position' => 2, 'key' => 'unique_id', 'label' => 'Member ID (unique_id)', 'example' => 'RED12345678'],
            ['position' => 3, 'key' => 'seq_pin', 'label' => 'Login PIN (seq_pin)', 'example' => '482910'],
            ['position' => 4, 'key' => 'secpwd', 'label' => 'Security password (secpwd)', 'example' => '••••••'],
            ['position' => 5, 'key' => 'registration_serial', 'label' => 'Registration serial number', 'example' => '1024'],
            ['position' => 6, 'key' => 'email', 'label' => 'Email address', 'example' => 'user@example.com'],
            ['position' => 7, 'key' => 'phone', 'label' => 'Mobile (dial code + phone)', 'example' => '+919876543210'],
            ['position' => 8, 'key' => 'country', 'label' => 'Country name', 'example' => 'India'],
            ['position' => 9, 'key' => 'sponsor_id', 'label' => 'Sponsor ID (parent unique_id)', 'example' => 'RED00000001'],
            ['position' => 10, 'key' => 'sponsor_name', 'label' => 'Sponsor name', 'example' => 'Jane Sponsor'],
        ];
    }

    /**
     * 1-based map for Meta template sending (auto-sized to template placeholder count).
     *
     * @return array<int, string>
     */
    public static function positionValuesForUser(User $user): array
    {
        $values = self::valuesForUser($user);
        $map = [];
        foreach (self::definitions() as $def) {
            $map[(int) $def['position']] = $values[$def['key']] ?? '';
        }

        return $map;
    }

    /**
     * @return array<string, string>
     */
    protected static function valuesForUser(User $user): array
    {
        $dial = CountryDial::normalize($user->dial_code ?? '');
        $phoneDigits = preg_replace('/\D+/', '', (string) $user->phone);
        $fullPhone = ($dial !== '' && $phoneDigits !== '') ? $dial.$phoneDigits : $phoneDigits;

        $sponsorId = '';
        $sponsorName = '';
        if (! empty($user->unique_id)) {
            $parentRow = UserParent::query()->where('user_id', $user->unique_id)->first();
            if ($parentRow && ! empty($parentRow->parent_id) && (string) $parentRow->parent_id !== '0') {
                $sponsorId = (string) $parentRow->parent_id;
                $sponsor = User::query()->where('unique_id', $sponsorId)->first();
                $sponsorName = (string) ($sponsor->name ?? '');
            }
        }

        return [
            'name' => (string) ($user->name ?? ''),
            'unique_id' => (string) ($user->unique_id ?? ''),
            'seq_pin' => (string) ($user->seq_pin ?? ''),
            'secpwd' => (string) ($user->secpwd ?? ''),
            'registration_serial' => (string) ($user->registration_serial ?? ''),
            'email' => (string) ($user->email ?? ''),
            'phone' => (string) $fullPhone,
            'country' => (string) ($user->country ?? ''),
            'sponsor_id' => $sponsorId,
            'sponsor_name' => $sponsorName,
        ];
    }
}
