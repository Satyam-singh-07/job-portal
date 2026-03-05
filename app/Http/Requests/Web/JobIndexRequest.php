<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class JobIndexRequest extends FormRequest
{
    public static function jobTypes(): array
    {
        return ['Full Time', 'Part Time', 'Contract', 'Freelance', 'Internship'];
    }

    public static function experienceLevels(): array
    {
        return ['Graduate', '1-2 years', '3+ years', '5+ years'];
    }

    public static function sortOptions(): array
    {
        return ['recent', 'salary_high', 'salary_low'];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:120'],
            'types' => ['nullable', 'array', 'max:10'],
            'types.*' => ['string', 'max:50'],
            'experience' => ['nullable', 'array', 'max:10'],
            'experience.*' => ['string', 'max:50'],
            'sort' => ['nullable', 'string', 'max:30'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function normalized(): array
    {
        $validated = $this->validated();

        $sort = (string) ($validated['sort'] ?? 'recent');

        return [
            'search' => $this->nullIfEmpty($validated['search'] ?? null),
            'location' => $this->normalizePlaceholder($validated['location'] ?? null, 'Location'),
            'category' => $this->normalizePlaceholder($validated['category'] ?? null, 'Category'),
            'types' => $this->sanitizeSelections($validated['types'] ?? [], self::jobTypes()),
            'experience' => $this->sanitizeSelections($validated['experience'] ?? [], self::experienceLevels()),
            'sort' => in_array($sort, self::sortOptions(), true) ? $sort : 'recent',
            'page' => max(1, (int) ($validated['page'] ?? 1)),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'search' => $this->trimString($this->input('search')),
            'location' => $this->trimString($this->input('location')),
            'category' => $this->trimString($this->input('category')),
            'types' => $this->trimArray($this->input('types', [])),
            'experience' => $this->trimArray($this->input('experience', [])),
            'sort' => $this->trimString($this->input('sort')),
        ]);
    }

    protected function sanitizeSelections(array $values, array $allowed): array
    {
        $allowedMap = array_fill_keys($allowed, true);

        return array_values(array_filter(array_unique($values), static fn (string $value): bool => isset($allowedMap[$value])));
    }

    protected function normalizePlaceholder(?string $value, string $placeholder): ?string
    {
        $normalized = $this->nullIfEmpty($value);

        return $normalized === $placeholder ? null : $normalized;
    }

    protected function nullIfEmpty(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }

    protected function trimString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        return trim($value);
    }

    protected function trimArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter(array_map(function (mixed $item): string {
            return is_string($item) ? trim($item) : '';
        }, $value), static fn (string $item): bool => $item !== ''));
    }
}
