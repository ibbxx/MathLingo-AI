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

        foreach (self::publicUrlBases() as $base) {
            $html = preg_replace_callback(
                '#(?<![A-Za-z0-9])' . preg_quote($base, '#') . '/([^"\'\s<>]+)#',
                function (array $match): string {
                    $path = self::extractPathFromUrl($match[0]);

                    return self::url($path) ?? $match[0];
                },
                $html
            ) ?? $html;
        }

        return $html;
    }

    public static function extractPathFromUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $url = html_entity_decode(trim($url), ENT_QUOTES | ENT_HTML5);
        $urlWithoutQuery = strtok($url, '?#') ?: $url;

        foreach (self::publicUrlBases() as $base) {
            if (str_starts_with($urlWithoutQuery, $base . '/')) {
                return rawurldecode(ltrim(substr($urlWithoutQuery, strlen($base)), '/'));
            }
        }

        return null;
    }

    /**
     * @return array<int, string>
     */
    public static function imagePathsFromHtml(?string $html): array
    {
        if (! $html) {
            return [];
        }

        preg_match_all('/<img\b[^>]*\bsrc\s*=\s*(?:"([^"]+)"|\'([^\']+)\'|([^\s>]+))/i', $html, $matches, PREG_SET_ORDER);

        if (! $matches) {
            return [];
        }

        $paths = [];
        foreach ($matches as $match) {
            $url = $match[1] ?: ($match[2] ?: ($match[3] ?? null));
            $path = self::extractPathFromUrl($url);
            if ($path) {
                $paths[] = $path;
            }
        }

        return array_values(array_unique($paths));
    }

    public static function deleteImagesFromHtml(?string $html): void
    {
        foreach (self::imagePathsFromHtml($html) as $path) {
            self::delete($path);
        }
    }

    /**
     * @return array<int, string>
     */
    private static function publicUrlBases(): array
    {
        $publicUrl = rtrim((string) config('filesystems.disks.public.url'), '/');
        $s3Url = rtrim((string) config('filesystems.disks.s3.url'), '/');
        $appStorageUrl = rtrim((string) config('app.url'), '/') . '/storage';

        return array_values(array_unique(array_filter([
            $s3Url,
            $publicUrl,
            $appStorageUrl,
            'http://127.0.0.1:8000/storage',
            'http://localhost:8000/storage',
            'http://localhost/storage',
            '/storage',
        ])));
    }
}
