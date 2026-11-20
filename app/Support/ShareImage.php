<?php

namespace App\Support;

use App\Http\Controllers\AdminHomepageController;
use Illuminate\Support\Str;

/**
 * The og:image / twitter:image of a page and its alt text.
 *
 * A page passes its own image (and the image's alt text when it has one). The alt text
 * falls back to the site's usual image alt: a name made from the file name, e.g.
 * "bakery-packaging.webp" -> "Bakery Packaging". It is never the page's meta title.
 *
 * A page with no image of its own, or whose image file is missing, gets the site default:
 * the homepage hero image set in the admin panel.
 */
class ShareImage
{
    /** Used only when the admin homepage hero image is not set or its file is missing. */
    const FALLBACK = 'uploads/Home-Banner.webp';

    /** @var array|null */
    private static $siteDefault;

    /**
     * @param  string|null  $image  path ("uploads/x.webp", "storage/x.webp", "x.webp") or full URL
     * @param  string|null  $alt    the image's alt text, if the page has one
     * @return array ['url' => absolute image URL, 'alt' => alt text]
     */
    public static function make($image, $alt = null): array
    {
        $url = self::url($image);
        if ($url === null) {
            return self::siteDefault();
        }

        $alt = trim((string) $alt);

        return ['url' => $url, 'alt' => $alt !== '' ? $alt : self::altFromFileName($url)];
    }

    /** The admin homepage hero image, else the fallback banner. */
    public static function siteDefault(): array
    {
        if (self::$siteDefault === null) {
            $heroImage = null;
            try {
                $heroImage = (new AdminHomepageController())->loadSettings()['hero_image'] ?? null;
            } catch (\Throwable $e) {
                // Settings table not reachable: use the fallback banner.
            }

            $url = self::url($heroImage) ?? self::url(self::FALLBACK) ?? asset(self::FALLBACK);
            self::$siteDefault = ['url' => $url, 'alt' => self::altFromFileName($url)];
        }

        return self::$siteDefault;
    }

    /** Absolute URL of the image, or null when it is empty or a local file that does not exist. */
    public static function url($image): ?string
    {
        $image = trim((string) $image);
        if ($image === '') {
            return null;
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            $url = preg_replace('#/public/(uploads|images|storage)/#i', '/$1/', $image);
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));
            $localPath = rawurldecode(ltrim((string) parse_url($url, PHP_URL_PATH), '/'));
            if ($host === strtolower(request()->getHost()) && !is_file(public_path($localPath))) {
                return null;
            }

            return $url;
        }

        // Same rules the page templates use: drop a leading "public/", and a bare file
        // name lives in storage/. Images uploaded to uploads/ may sit in storage/uploads/.
        $path = rawurldecode(rtrim(preg_replace('#^/?public/#i', '', ltrim($image, '/')), '/'));
        $candidates = Str::startsWith($path, ['storage/', 'uploads/', 'images/'])
            ? [$path, 'storage/' . $path]
            : ['storage/' . $path, $path];

        foreach (array_unique($candidates) as $candidate) {
            if (is_file(public_path($candidate))) {
                // Encode each segment so file names with spaces give a valid URL.
                return asset(implode('/', array_map('rawurlencode', explode('/', $candidate))));
            }
        }

        return null;
    }

    /** "custom-cookie-boxes-<uuid>.webp" -> "Custom Cookie Boxes", like the alt text on the page images. */
    public static function altFromFileName(string $image): string
    {
        $name = pathinfo(rawurldecode((string) parse_url($image, PHP_URL_PATH)), PATHINFO_FILENAME);
        $name = preg_replace('/-[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i', '', $name);
        $name = trim(preg_replace('/\s+/', ' ', str_replace(['-', '_'], ' ', $name)));

        return $name !== '' ? ucwords($name) : 'Go Custom Boxes';
    }
}
