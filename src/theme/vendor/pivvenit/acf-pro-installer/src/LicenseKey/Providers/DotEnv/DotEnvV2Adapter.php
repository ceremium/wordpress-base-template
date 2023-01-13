<?php
declare(strict_types=1);

namespace PivvenIT\Composer\Installers\ACFPro\LicenseKey\Providers\DotEnv;

use Dotenv\Dotenv;

class DotEnvV2Adapter implements DotEnvAdapterInterface
{
    /**
     * @inheritDoc
     */
    public function load(string $path): void
    {
        /**
         * @noinspection PhpParamsInspection This is fallback code
         */
        $dotenv = new Dotenv(getcwd());
        $dotenv->safeLoad();
    }
}
