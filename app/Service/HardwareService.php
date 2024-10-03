<?php
declare(strict_types=1);

namespace App\Service;

use Laravel\Pulse\Recorders\Servers;

final class HardwareService extends Servers
{
    public function __construct() {}

    public function getStorage(array $directories = ['/'])
    {
        return collect($directories)
            ->map(fn (string $directory) => [
                'directory' => $directory,
                'total' => $total = intval(round(disk_total_space($directory) / 1024 / 1024)), // MB
                'used' => intval(round($total - (disk_free_space($directory) / 1024 / 1024))), // MB
            ])
            ->all();
    }

    public function getCpu(): int
    {
        return $this->cpu();
    }

    public function getMemory(): array
    {
        return $this->memory();
    }
}
