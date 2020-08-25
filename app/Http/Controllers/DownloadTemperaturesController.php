<?php

namespace App\Http\Controllers;

use App\Temperature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use JamesMills\LaravelTimezone\Facades\Timezone;

class DownloadTemperaturesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $log = auth()->user()->currentLog;

        $writer = SimpleExcelWriter::streamDownload(Str::snake($log->title) . '_temperatures_report' . time() . '.xlsx');

        $query = auth()->user()->is_owner
            ? Temperature::query()->with('user')
            : auth()->user()->temperatures();

        $query
            ->where('log_id', $log->id)
            ->when($request->search, fn ($q) => $q->search($request->search))
            ->when($request->filter === 'today', fn ($q) => $q->today())
            ->when($request->filter === 'yesterday', fn ($q) => $q->yesterday())
            ->when($request->filter === 'week', fn ($q) => $q->thisWeek())
            ->when($request->filter === 'month', fn ($q) => $q->thisMonth())
            ->latest()
            ->get()
            ->each(function ($temperature) use ($writer) {
                $writer->addRow([
                    'name' => $temperature->user->name,
                    'temperature' => $temperature->temperature . ' ' . $temperature->scale,
                    'date_time' => Timezone::convertToLocal($temperature->created_at, 'M d, Y h:i a')
                ]);
            });

        $writer->toBrowser();
    }
}
