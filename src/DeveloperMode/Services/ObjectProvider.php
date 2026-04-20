<?php

namespace DeveloperMode\Services;

interface ObjectProvider
{

    public static function toObject(array $data);

    public function toArray(): array;
}
