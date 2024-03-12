<?php

declare(strict_types=1);

/*
 * This file is part of the worldia/coding-standards package.
 * (c) Worldia <developers@worldia.com>
 */

namespace CodingStandards;

use PhpCsFixer;

class Factory
{
    public static function createPhpCsFixerConfig(string $rootDirectory, array $options = []): PhpCsFixer\Config
    {
        $package = json_decode(file_get_contents($rootDirectory.'/composer.json'), true);
        $header = sprintf("This file is part of the %s package.\n(c) Worldia <developers@worldia.com>", $package['name']);

        $defaults = [
            'dirs' => ['lib', 'vendor', 'var'],
            'rules' => [
                '@PSR12' => true,
                '@Symfony' => true,
                '@Symfony:risky' => true,
                'single_line_throw' => false,
                'header_comment' => ['header' => $header],
            ],
        ];

        $config = array_merge_recursive($defaults, $options);

        $finder = (new PhpCsFixer\Finder())
            ->exclude($config['dirs'])
            ->in($rootDirectory);

        return (new PhpCsFixer\Config())
            ->setUsingCache(false)
            ->setRiskyAllowed(true)
            ->setRules($config['rules'])
            ->setFinder($finder);
    }
}
