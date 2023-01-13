<?php
declare(strict_types=1);

namespace PivvenIT\Composer\Installers\ACFPro\LicenseKey\Appenders;

use \InvalidArgumentException;

class UrlLicenseKeyAppender implements UrlLicenseKeyAppenderInterface
{

    /**
     * @inheritdoc
     */
    public function append(string $url, string $licenseKey): string
    {
        $parsedUrl = parse_url($url);
        if (!is_array($parsedUrl) ||
            !array_key_exists('scheme', $parsedUrl) ||
            !array_key_exists('host', $parsedUrl) ||
            !array_key_exists('path', $parsedUrl) ||
            !array_key_exists('query', $parsedUrl)
        ) {
            throw new InvalidArgumentException('Invalid URL');
        }
        ['scheme' => $scheme, 'host' => $host, 'path' => $path, 'query' => $query ] = $parsedUrl;
        $queryParams = [];
        parse_str($query, $queryParams);
        $queryParams['k'] = $licenseKey;
        $query = http_build_query($queryParams);

        return "{$scheme}://{$host}{$path}?{$query}";
    }
}
