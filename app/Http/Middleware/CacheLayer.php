<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheLayer
{
    private const EXCLUDED_URLS = [];

    public function handle(Request $request, Closure $next): Response
    {
        $method = $request->getMethod();

        if ('GET' !== $method) {
            $response = $next($request);

            if ($response->isSuccessful()) {
                $tag = $request->url();

                if ('PATCH' === $method || 'DELETE' === $method) {
                    $tag = mb_substr($tag, 0, mb_strrpos($tag, '/'));
                }

                cache()->tags([$tag])->flush();
            }

            return $response;
        }

        foreach (self::EXCLUDED_URLS as $pattern) {
            if (preg_match($pattern, $request->getRequestUri())) {
                return $next($request);
            }
        }

        $cacheKey = $this->getCacheKey($request);

        $exception = null;

        $response = cache()
            ->tags([$request->url()])
            ->remember(
                key: $cacheKey,
                ttl: config('cache.ttl'),
                callback: function () use ($next, $request, &$exception) {
                    $res = $next($request);

                    if (property_exists($res, 'exception') && null !== $res->exception) {
                        $exception = $res;

                        return null;
                    }

                    return gzcompress($res->getContent());
                }
            );

        return $exception ?? response(gzuncompress($response));
    }

    private function getCacheKey(Request $request): string
    {
        $routeParameters = ! empty($request->route()->parameters) ? $request->route()->parameters : [auth()->user()->id];
        $allParameters = array_merge($request->all(), $routeParameters);
        $this->recursiveSort($allParameters);

        return $request->url() . json_encode($allParameters);
    }

    private function recursiveSort(&$array): void
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursiveSort($value);
            }
        }

        ksort($array);
    }
}
