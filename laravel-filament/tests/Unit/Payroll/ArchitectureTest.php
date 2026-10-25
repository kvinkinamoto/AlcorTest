<?php

declare(strict_types=1);

namespace Tests\Unit\Payroll;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Keeps the DDD boundaries honest: inside a context the domain and application layers do not know the
 * framework or the infrastructure, and contexts only meet through the few published seams listed here.
 */
final class ArchitectureTest extends TestCase
{
    private const ROOT = 'App\\Payroll\\';

    /** Context => namespaces (relative to App\Payroll\) it may import besides its own and SharedKernel. */
    private const ALLOWED_CONTEXT_DEPENDENCIES = [
        'SharedKernel' => [],
        'Workforce' => [],
        'Earning' => [],
        'PayrollCalculation' => ['Earning\\Application\\Port\\', 'Workforce\\Application\\Query\\'],
        'Audit' => ['Earning\\Domain\\', 'Workforce\\Application\\Query\\'],
    ];

    /** @return iterable<string, array{string, list<string>}> */
    public static function files(): iterable
    {
        $src = str_replace('\\', '/', (string) realpath(dirname(__DIR__, 3) . '/app/Payroll')) . '/';
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($it as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $relative = substr(str_replace('\\', '/', $file->getPathname()), strlen($src));
            preg_match_all('/^use ([A-Za-z\\\\]+)/m', file_get_contents($file->getPathname()), $m);
            yield $relative => [$relative, $m[1]];
        }
    }

    /** @param list<string> $imports */
    #[DataProvider('files')]
    public function test_imports_respect_layers_and_contexts(string $relative, array $imports): void
    {
        [$context, $layer] = explode('/', $relative, 3);
        $own = self::ROOT . $context . '\\';
        $this->addToAssertionCount(1); // a file without imports is trivially fine

        foreach ($imports as $import) {
            if (!str_starts_with($import, self::ROOT)) {
                // Only infrastructure adapters may use the framework.
                if ($layer !== 'Infrastructure') {
                    $this->assertDoesNotMatchRegularExpression('/^(Illuminate|Symfony|Laravel|Filament|Livewire)\\\\/', $import, "{$relative} must not depend on a framework ({$import})");
                }
                continue;
            }

            $allowedOther = array_filter(self::ALLOWED_CONTEXT_DEPENDENCIES[$context], static fn ($ns) => str_starts_with($import, self::ROOT . $ns));
            $this->assertTrue(
                str_starts_with($import, $own) || str_starts_with($import, self::ROOT . 'SharedKernel\\') || $allowedOther !== [],
                "{$relative} imports {$import}: contexts may only meet through their published seams",
            );

            if ($layer === 'Domain') {
                $this->assertDoesNotMatchRegularExpression('/\\\\(Application|Infrastructure)\\\\/', $import, "{$relative}: the domain must not depend on Application or Infrastructure ({$import})");
            }
            if ($layer === 'Application') {
                $this->assertDoesNotMatchRegularExpression('/\\\\Infrastructure\\\\/', $import, "{$relative}: the application layer must not depend on Infrastructure ({$import})");
            }
        }
    }
}
