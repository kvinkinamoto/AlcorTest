<?php

declare(strict_types=1);

namespace Alcor\Payroll\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Keeps the DDD boundaries honest: layers inside a context point inwards, and contexts only know each
 * other through the few published seams listed here.
 */
final class ArchitectureTest extends TestCase
{
    private const ROOT = 'Alcor\\Payroll\\';

    /**
     * Context => namespaces (relative to Alcor\Payroll\) it may import besides its own and SharedKernel\Domain|Application|Money|Period.
     * Anything not listed is forbidden.
     */
    private const ALLOWED_CONTEXT_DEPENDENCIES = [
        'SharedKernel' => [],
        'Workforce' => [],
        'Earning' => [],
        'PayrollCalculation' => ['Earning\\Application\\Port\\', 'Workforce\\Application\\Query\\'],
        'Audit' => ['Earning\\Domain\\', 'Workforce\\Application\\Query\\'],
    ];

    /** @return iterable<string, array{string, string, list<string>}> */
    public static function files(): iterable
    {
        $src = str_replace('\\', '/', (string) realpath(dirname(__DIR__) . '/src')) . '/';
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($it as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $relative = substr(str_replace('\\', '/', $file->getPathname()), strlen($src));
            if (!str_contains($relative, '/')) {
                continue; // composition root files (PayrollApp, MySqlSchema) may import everything
            }
            preg_match_all('/^use ([A-Za-z\\\\]+)/m', file_get_contents($file->getPathname()), $m);
            yield $relative => [$relative, $relative, $m[1]];
        }
    }

    /** @param list<string> $imports */
    #[DataProvider('files')]
    public function test_imports_respect_layers_and_contexts(string $name, string $relative, array $imports): void
    {
        [$context, $layer] = explode('/', $relative, 3);
        $own = self::ROOT . $context . '\\';

        foreach ($imports as $import) {
            if (!str_starts_with($import, self::ROOT)) {
                $this->assertDoesNotMatchRegularExpression('/^(Illuminate|Symfony|Laravel)\\\\/', $import, "{$relative} must not depend on a framework ({$import})");
                continue;
            }

            $inOwnContext = str_starts_with($import, $own);
            $inSharedKernel = str_starts_with($import, self::ROOT . 'SharedKernel\\');
            $allowedOther = array_filter(self::ALLOWED_CONTEXT_DEPENDENCIES[$context], static fn ($ns) => str_starts_with($import, self::ROOT . $ns));

            $this->assertTrue(
                $inOwnContext || $inSharedKernel || $allowedOther !== [],
                "{$relative} imports {$import}: contexts may only meet through their published seams",
            );

            if ($layer === 'Domain') {
                $outward = preg_match('/\\\\(Application|Infrastructure)\\\\/', $import) === 1;
                $this->assertFalse($outward, "{$relative}: the domain must not depend on Application or Infrastructure ({$import})");
            }
            if ($layer === 'Application') {
                $this->assertDoesNotMatchRegularExpression('/\\\\Infrastructure\\\\/', $import, "{$relative}: the application layer must not depend on Infrastructure ({$import})");
            }
        }

        if ($layer === 'Domain' || $layer === 'Application') {
            $source = file_get_contents(dirname(__DIR__) . '/src/' . $relative);
            $this->assertStringNotContainsString('PDO', $source, "{$relative} must not touch the database");
        }
    }
}
