<?php

namespace App\Charts;

use App\Models\mahasiswa;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\PieChart;

class AngkatanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {
        $mahasiswaangkatan = mahasiswa::get();
        $data = [
            $mahasiswaangkatan->where('angkatan',2019)->count(),
            $mahasiswaangkatan->where('angkatan',2020)->count(),
            $mahasiswaangkatan->where('angkatan',2021)->count(),
            $mahasiswaangkatan->where('angkatan',2022)->count(),
        ];
        $label = [
            'angkatan 2019',
            'angkatan 2020',
            'angkatan 2021',
            'angkatan 2022',
        ];


        return $this->chart->pieChart()
            ->setTitle('Data Mahasiswa PerAngkatan')
            ->setSubtitle(('Di tahun '.date('Y')))
            ->addData($data)
            ->setLabels($label);
    }
}
?>