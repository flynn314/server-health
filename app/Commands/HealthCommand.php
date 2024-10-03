<?php
declare(strict_types=1);

namespace App\Commands;

use App\Service\HardwareService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HealthCommand extends Command
{
    protected $signature = 'server:health';
    protected $description = 'Send server health report.';

    public function handle(HardwareService $hs): void
    {
        $appName = Str::slug(config('app.name'));
        $storage = $hs->getStorage()[0];

        $url = sprintf(
            '%s/health?name=%s&cpu=%d&memory=%s&storage=%s',
            config('connect.url'),
            $appName,
            $hs->getCpu(), // todo optimize (heavy)
            implode(',', $hs->getMemory()),
            implode(',', [$storage['total'], $storage['used']]),
        );

        $r = Http::get($url);

        if (JsonResponse::HTTP_OK !== $r->getStatusCode()) {
            $this->error($r->json()['message']);
        } else {
            $this->info($r->json()['message']);
        }

        $this->line(sprintf('%ss', microtime(true) - LARAVEL_START));
    }

    public function schedule(Schedule $schedule): void
    {
        $schedule->command(static::class)->everyFifteenSeconds()->withoutOverlapping();
    }
}
