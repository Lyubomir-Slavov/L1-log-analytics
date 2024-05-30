<?php
declare(strict_types=1);

namespace App\Service\Reader;

interface Reader
{
    public function load(string $path): void;

    /**
     * @return \Generator<string>
     */
    public function iterator(): \Generator;
}
