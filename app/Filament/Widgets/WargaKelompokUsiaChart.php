<?php

namespace App\Filament\Widgets;

use App\Models\Rtrw;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WargaKelompokUsiaChart extends ApexChartWidget
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
    protected static string $chartId = 'wargaKelompokUsiaChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Statistik Kelompok Usia';

    protected function getFooter(): string|View
    {
        return new HtmlString('<p class="text-xs"><b>Balita</b> 0 - 5 tahun | <b>Anak-Anak</b> 6 - 12 tahun | <b>Remaja</b> 13 - 18 tahun | <b>Usia Produktif</b> 19 - 55 tahun | <b>Lansia</b> 56 tahun keatas</p>');
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

    public function getDescription(): ?string
    {
        return 'The number of blog posts published per month.';
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

        $ageRanges = [
            '0-5' => 'Balita',
            '6-12' => 'Anak-anak',
            '13-18' => 'Remaja',
            '19-55' => 'Usia Produktif',
            '56-' => 'Lansia'
        ];

        $genderList = ['laki-laki', 'perempuan'];

        $wargaData = DB::table('wargas')
            ->select('gender', DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age'))
            ->when($rtrw_id !== null, function ($query) use ($rtrw_id) {
                return $query->where('rtrw_id', $rtrw_id);
            })
            ->whereIn('gender', $genderList)
            ->get();
        
        $genderAgeData = [];
        
        // Inisialisasi data untuk setiap rentang usia
        foreach ($ageRanges as $range => $label) {
            foreach ($genderList as $gender) {
                $genderAgeData[$label][$gender] = 0;
            }
        }
        
        // Menghitung jumlah warga dalam setiap rentang usia dan jenis kelamin
        foreach ($wargaData as $warga) {
            foreach ($ageRanges as $range => $label) {
                $explodedRange = explode('-', $range);
                $minAge = intval($explodedRange[0]);
                $maxAge = intval($explodedRange[1]) ?: 200; // Gunakan angka besar untuk rentang terakhir
                if ($warga->age >= $minAge && $warga->age <= $maxAge) {
                    $genderAgeData[$label][$warga->gender]++;
                }
            }
        }
        
        $categories = array_values($ageRanges);
        $seriesData = [];
        
        foreach ($genderList as $gender) {
            $data = [];
            foreach ($ageRanges as $range => $label) {
                $data[] = $genderAgeData[$label][$gender];
            }
            $seriesData[] = [
                'name' => ucfirst($gender),
                'data' => $data,
            ];
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 350,
                'stacked' => true,
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
            'colors' => ['#00DA70', '#FF4560'],
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
