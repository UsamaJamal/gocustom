<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanonicalTrailingSlash
{
    /**
     * Redirect public HTML pages to their trailing-slash URL.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $path = trim($request->path(), '/');

        // Return 410 Gone for permanently removed spam / prize URLs without redirecting
        if ($path === 'delivery-information.php'
            || str_starts_with($path, 'prize/')
            || $path === 'prize'
            || ($request->getQueryString() && (str_starts_with($request->getQueryString(), 'prize') || str_contains($request->getQueryString(), 'prize/')))) {
            abort(410, 'Gone');
        }

        // Redirect www to non-www canonical domain (e.g. www.gocustomboxes.com -> gocustomboxes.com)
        $host = $request->getHost();
        if (str_starts_with($host, 'www.')) {
            $nonWwwHost = substr($host, 4);
            $uri = $request->getRequestUri();

            $isHomepage = ($path === '');
            $isSpecial = str_starts_with($path, 'admin/') || $path === 'admin'
                || str_starts_with($path, 'api/') || $path === 'api'
                || str_starts_with($path, 'storage/')
                || str_starts_with($path, '_debugbar/')
                || str_contains(basename($path), '.');

            // If the path needs a canonical trailing slash, include it in a single 301 hop
            if (!$isHomepage && !$isSpecial && !str_ends_with($request->getPathInfo(), '/')) {
                $uri = '/' . $path . '/';
                if ($request->getQueryString()) {
                    $uri .= '?' . $request->getQueryString();
                }
            }

            return redirect()->to('https://' . $nonWwwHost . $uri, 301);
        }

        // Keep the homepage, backend, API endpoints, and real files unchanged.
        if ($path === ''
            || str_starts_with($path, 'admin/') || $path === 'admin'
            || str_starts_with($path, 'api/') || $path === 'api'
            || str_starts_with($path, 'storage/')
            || str_starts_with($path, '_debugbar/')
            || str_contains(basename($path), '.')) {
            return $next($request);
        }

        if (!str_ends_with($request->getPathInfo(), '/')) {
            $url = $request->getSchemeAndHttpHost() . '/' . $path . '/';

            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }

            return redirect()->to($url, 301);
        }

        return $next($request);
    }
}
