<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

final class PublicStorage
{
    public static function diskName(): string
    {
        return (string) config('filesystems.public_assets_disk', config('filesystems.default', 'public'));
    }

    public static function store(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, [
            'disk' => self::diskName(),
            'visibility' => 'public',
        ]);

        if (! is_string($path) || $path === '') {
            throw new RuntimeException('Gagal menyimpan file ke storage publik.');
        }

        return $path;
    }

    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk(self::diskName())->url($path);
    }

    public static function versionedUrl(?string $path, mixed $version): ?string
    {
        $url = self::url($path);

        if (! $url || $version === null || $version === '') {
            return $url;
        }

        return $url . (str_contains($url, '?') ? '&' : '?') . 'v=' . rawurlencode((string) $version);
    }

    public static function exists(?string $path): bool
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return false;
        }

        return Storage::disk(self::diskName())->exists($path);
    }

    public static function delete(?string $path): bool
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return false;
        }

        return Storage::disk(self::diskName())->delete($path);
    }

    public static function rewritePublicUrls(?string $html): string
    {
        if (! $html) {
            return '';
        }

        $publicUrl = rtrim((string) config('filesystems.disks.public.url'), '/');
        $appStorageUrl = rtrim((string) config('app.url'), '/') . '/storage';

        $bases = array_values(array_unique(array_filter([
            $publicUrl,
            $appStorageUrl,
            'http://127.0.0.1:8000/storage',
            'http://localhost:8000/storage',
            'http://localhost/storage',
            '/storage',
        ])));

        foreach ($bases as $base) {
            $html = preg_replace_callback(
                '#(?<![A-Za-z0-9])' . preg_quote($base, '#') . '/([^"\'\s<>]+)#',
                fn (array $match): string => self::url(rawurldecode($match[1])) ?? $match[0],
                $html
            ) ?? $html;
        }

        return $html;
    }
}
