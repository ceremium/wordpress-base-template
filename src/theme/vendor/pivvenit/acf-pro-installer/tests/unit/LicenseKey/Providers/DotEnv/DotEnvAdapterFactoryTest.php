<?php
declare(strict_types=1);

namespace PivvenIT\Composer\Installers\ACFPro\Test\LicenseKey\Providers\DotEnv;

use PHPUnit\Framework\TestCase;
use PivvenIT\Composer\Installers\ACFPro\LicenseKey\Providers\DotEnv\DotEnvAdapterFactory;
use PivvenIT\Composer\Installers\ACFPro\LicenseKey\Providers\DotEnv\DotEnvV2Adapter;
use PivvenIT\Composer\Installers\ACFPro\LicenseKey\Providers\DotEnv\DotEnvV3Adapter;
use PivvenIT\Composer\Installers\ACFPro\LicenseKey\Providers\DotEnv\DotEnvV4Adapter;
use PivvenIT\Composer\Installers\ACFPro\LicenseKey\Providers\DotEnv\DotEnvV5Adapter;

class DotEnvAdapterFactoryTest extends TestCase
{
    public function testBuildWithV4ReturnsV4Adapter()
    {
        $mock = new class {
            public static function createImmutable()
            {
                return;
            }
        };
        $this->assertInstanceOf(DotEnvV4Adapter::class, DotEnvAdapterFactory::build($mock));
    }

    public function testBuildWithV5ReturnsV5Adapter()
    {
        $mock = new class {
            public static function createUnsafeImmutable()
            {
                return;
            }
        };
        $this->assertInstanceOf(DotEnvV5Adapter::class, DotEnvAdapterFactory::build($mock));
    }

    public function testBuildWithV3ReturnsV3Adapter()
    {
        $mock = new class {
            public static function create()
            {
                return;
            }
        };
        $this->assertInstanceOf(DotEnvV3Adapter::class, DotEnvAdapterFactory::build($mock));
    }

    public function testBuildWithV2ReturnsV2Adapter()
    {
        $mock = new class {
            public function load()
            {
                return;
            }
        };
        $this->assertInstanceOf(DotEnvV2Adapter::class, DotEnvAdapterFactory::build($mock));
    }

    public function testBuildReturnsCorrectAdapter()
    {
        if (DotEnvAdapterFactory::isV5()) {
            $mock = new class {
                public static function createUnsafeImmutable()
                {
                    return;
                }
            };
        } elseif (DotEnvAdapterFactory::isV4()) {
            $mock = new class {
                public static function createImmutable()
                {
                    return;
                }
            };
        } elseif (DotEnvAdapterFactory::isV3()) {
            $mock = new class {
                public static function create()
                {
                    return;
                }
            };
        } else {
            $mock = new class {
            };
        }
        $this->assertInstanceOf(get_class(DotEnvAdapterFactory::build()), DotEnvAdapterFactory::build($mock));
    }
}
