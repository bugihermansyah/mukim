<?php

namespace App\Filament\Widgets;

use App\Models\Rtrw;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WargaReligionChart extends ApexChartWidget
{
    protected static ?string $pollingInterval = null;
    
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'wargaReligionChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Statistik Agama';

    protected function getFormSchema(): array
    {
        return [
            Select::make('rtrw_id')
                ->label('Wilayah')
                ->options(Rtrw::query()->pluck('name', 'id'))
                ->reactive()
                ->afterStateUpdated(function () {
                    $this->updateOptions();
                }),
    
        ];
    }

    protected static bool $deferLoading = true;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        if (!$this->readyToLoad) {
            return [];
        }
     
        $rtrw_id = $this->filterFormData['rtrw_id'];

        $agamaList = [
            'islam',
            'kristen',
            'katolik',
            'hindu',
            'budha',
            'konghuchu',
            'kepercayaan'];
        $agamaData = DB::table('wargas')
            ->select('religion', DB::raw('COUNT(*) as total'))
            ->when($rtrw_id !== null, function ($query) use ($rtrw_id) {
                return $query->where('rtrw_id', $rtrw_id);
            })
            ->whereIn('religion', $agamaList)
            ->groupBy('religion')
            ->get()
            ->pluck('total', 'religion')
            ->toArray();
            
        // Tambahkan entri kosong untuk agama yang tidak memiliki data
        foreach ($agamaList as $agama) {
            if (!array_key_exists($agama, $agamaData)) {
                $agamaData[$agama] = 0;
            }
        }

        // Urutkan data berdasarkan urutan agamaList
        $sortedAgamaData = [];
        foreach ($agamaList as $agama) {
            $sortedAgamaData[$agama] = $agamaData[$agama];
        }

        $categories = array_keys($sortedAgamaData);
        $agamaValues = array_values($sortedAgamaData);

        $seriesData = [
            [
                'name' => 'Jumlah Warga',
                'data' => $agamaValues,
            ],
        ];

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 350,
                'toolbar' => [
                    'export' => [
                        'csv' => [
                            'columnDelimiter' => ';'
                        ],
                    ],
                ],
            ],
            'series' => $seriesData,
            'xaxis' => [
                'categories' => $categories,
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
            'colors' => ['#00DA70'],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '55%',
                    'endingShape' => 'rounded'
                ],
            ],
        ];
    }
}
