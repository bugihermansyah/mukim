<?php

namespace App\Filament\Widgets;

use App\Models\Warga;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class KelompokUsiaChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'kelompokUsiaChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Kelompok Usia Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $allAgeRanges = ['Balita', 'Anak-anak', 'Remaja', 'Dewasa', 'Lansia'];
    
        $ageData = DB::table(
            DB::raw('(
                SELECT TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS umur, wargas.rtrw_id, rtrws.name
                FROM wargas
                LEFT JOIN rtrws ON wargas.rtrw_id = rtrws.id
            ) as kelompok_usia'))
            ->select(DB::raw("
                CASE
                    WHEN umur <= 5 THEN 'Balita'
                    WHEN umur BETWEEN 6 and 12 THEN 'Anak-anak'
                    WHEN umur BETWEEN 13 and 18 THEN 'Remaja'
                    WHEN umur BETWEEN 19 and 55 THEN 'Dewasa'
                    WHEN umur >= 56 THEN 'Lansia'
                END as age_range,
                name
            "), DB::raw('COUNT(*) as count'))
            ->groupBy('rtrw_id', 'age_range')
            ->orderBy('rtrw_id')
            ->get();
    
        // Organize the data by rtrw_id
        $chartData = [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [],
            'xaxis' => [
                'categories' => $allAgeRanges,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    
        foreach ($ageData as $data) {
            $rtrwId = $data->rtrw_id ?? null;
    
            if (!isset($chartData['series'][$rtrwId])) {
                $chartData['series'][$rtrwId] = [
                    'name' => $data->name ?? 'N/A',
                    'data' => array_fill_keys($allAgeRanges, 0),
                ];
            }
    
            $chartData['series'][$rtrwId]['data'][$data->age_range] = $data->count;
        }
    
        // Convert series data to array
        $chartData['series'] = array_values($chartData['series']);
    
        return $chartData;
    }
    
}
