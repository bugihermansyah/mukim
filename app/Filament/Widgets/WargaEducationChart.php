<?php

namespace App\Filament\Widgets;

use App\Models\Rtrw;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WargaEducationChart extends ApexChartWidget
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
    protected static string $chartId = 'wargaEducationChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Statisik Pendidikan';
    
    public function getHeading(): string
    {
        return 'Statistik Pendidikan';
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

        // Ambil daftar pendidikan dari tabel educations
        $educationData = DB::table('educations')
            ->pluck('name')
            ->toArray();

        // Buat variabel $educationList dari hasil query
        $educationList = $educationData;

        $educationData = DB::table('wargas')
            ->select('educations.name as education', DB::raw('COUNT(*) as total'))
            ->leftJoin('educations', 'wargas.education_id', '=', 'educations.id')
            ->when($rtrw_id !== null, function ($query) use ($rtrw_id) {
                return $query->where('wargas.rtrw_id', $rtrw_id);
            })
            ->whereIn('educations.name', $educationList)
            ->groupBy('educations.name')
            ->get()
            ->pluck('total', 'education')
            ->toArray();

        // Tambahkan entri kosong untuk kategori yang tidak memiliki data
        foreach ($educationList as $education) {
            if (!array_key_exists($education, $educationData)) {
                $educationData[$education] = 0;
            }
        }

        // Urutkan data berdasarkan urutan educationList
        $sortedEducationData = [];
        foreach ($educationList as $education) {
            $sortedEducationData[$education] = $educationData[$education];
        }

        $categories = array_keys($sortedEducationData);
        $educationValues = array_values($sortedEducationData);

        $seriesData = [
            [
                'name' => 'Jumlah Warga',
                'data' => $educationValues,
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
