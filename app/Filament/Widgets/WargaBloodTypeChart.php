<?php

namespace App\Filament\Widgets;

use App\Models\Rtrw;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WargaBloodTypeChart extends ApexChartWidget
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
    protected static string $chartId = 'wargaBloodTypeChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Statistik Gol. Darah';

    public function getHeading(): string
    {
        return 'Statistik Gol. Darah';
    }

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

        $bloodList = [
            'A',
            'B',
            'AB',
            'O',
            'NULL'];

        $bloodData = DB::table('wargas')
                ->select(DB::raw('IFNULL(blood_type, "NULL") as blood_type'), DB::raw('COUNT(*) as total'))
                ->when($rtrw_id !== null, function ($query) use ($rtrw_id) {
                    return $query->where('rtrw_id', $rtrw_id);
                })
                ->whereIn(DB::raw('IFNULL(blood_type, "NULL")'), $bloodList)
                ->groupBy(DB::raw('IFNULL(blood_type, "NULL")'))
                ->get()
                ->pluck('total', 'blood_type')
                ->toArray();

        // Tambahkan entri kosong untuk agama yang tidak memiliki data
        foreach ($bloodList as $blood) {
            if (!array_key_exists($blood, $bloodData)) {
                $bloodData[$blood] = 0;
            }
        }

        // Urutkan data berdasarkan urutan bloodList
        $sortedBloodData = [];
        foreach ($bloodList as $blood) {
            $sortedBloodData[$blood] = $bloodData[$blood];
        }

        $categories = array_keys($sortedBloodData);
        $bloodValues = array_values($sortedBloodData);

        $seriesData = [
            [
                'name' => 'Jumlah Warga',
                'data' => $bloodValues,
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
