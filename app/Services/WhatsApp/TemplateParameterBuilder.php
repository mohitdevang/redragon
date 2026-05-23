<?php

namespace App\Services\WhatsApp;

/**
 * Builds Meta template body parameters from 1-based position maps.
 * Unmapped positions are sent as empty; Meta may require a visible placeholder (see MetaCloudClient).
 */
class TemplateParameterBuilder
{
    /**
     * @param  array<int, string>  $positionValues  1 => OTP, 2 => minutes, …
     * @return array<int, string> 0-indexed list for Meta API
     */
    public static function assemble(int $parameterCount, array $positionValues): array
    {
        if ($parameterCount <= 0) {
            return [];
        }

        $params = [];
        for ($pos = 1; $pos <= $parameterCount; $pos++) {
            $params[] = array_key_exists($pos, $positionValues)
                ? (string) $positionValues[$pos]
                : '';
        }

        return $params;
    }

    /**
     * @param  array<int, string>  $positionValues
     */
    public static function initialParameterCount(array $positionValues, ?int $settingsFallback = null): int
    {
        if ($positionValues !== []) {
            return max(array_map('intval', array_keys($positionValues)));
        }

        return max(0, (int) $settingsFallback);
    }

    /**
     * Meta rejects wholly empty text parameters — use a single space for "empty" slots.
     *
     * @param  array<int, string>  $params
     * @return array<int, string>
     */
    public static function applyEmptyPlaceholder(array $params, string $placeholder = ' '): array
    {
        return array_map(
            static fn (string $value) => $value === '' ? $placeholder : $value,
            $params
        );
    }
}
