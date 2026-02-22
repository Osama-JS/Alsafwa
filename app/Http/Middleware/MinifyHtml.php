<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->isHtml($response)) {
            $content = $response->getContent();
            $minified = $this->minify($content);
            $response->setContent($minified);
        }

        return $response;
    }

    protected function isHtml($response)
    {
        $contentType = $response->headers->get('Content-Type');
        return strpos($contentType, 'text/html') !== false;
    }

    protected function minify($input)
    {
        // Simple minification
        $search = [
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            ''
        ];

        return preg_replace($search, $replace, $input);
    }
}
