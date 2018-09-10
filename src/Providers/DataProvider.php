<?php

namespace App\Providers;

Interface DataProvider
{
    public function getData(): array;

    public function prepareData(array $items): void;

    public function getRemoteData(string $path): ?array;
}