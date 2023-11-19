<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class KelompokAgamaChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'kelompokAgamaChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'KelompokAgamaChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $allAgeRanges = ['Balita', 'Anak-anak', 'Remaja', 'Dewasa', 'Lansia'];

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => '001/001',
                    'data' => [7, 4, 6, 10, 14],
                ],
                [
                    'name' => '001/002',
                    'data' => [10, 13, 14, 2, 15],
                ],
            ],
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
                    'distributed' => true,
                ],
            ],
        ];
    }
}
