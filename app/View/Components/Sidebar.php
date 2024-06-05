<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu = [
            [
                'name' => 'Master Data',
                'url' => '',
                'sub_menu' => [
                    [
                        'name' => 'Jenis Simpanan',
                        'url' => url('/master-data/jenis-simpanan'),
                        'sub_menu' => []
                    ],
                    [
                        'name' => 'Anggota',
                        'url' => url('/master-data/anggota'),
                        'sub_menu' => []
                    ],
                    [
                        'name' => 'Pekerjaan',
                        'url' => url('/master-data/pekerjaan'),
                        'sub_menu' => []
                    ],
                    [
                        'name' => 'Jenis Akun',
                        'url' => url('/master-data/jenis-akun'),
                        'sub_menu' => []
                    ],
                    [
                        'name' => 'Data Kas',
                        'url' => url('/master-data/data-kas'),
                        'sub_menu' => []
                    ],
                    [
                        'name' => 'Departemen',
                        'url' => url('/master-data/departemen'),
                        'sub_menu' => []
                    ],
                ]
            ],
            [
                'name' => 'Transactions',
                'url' => '',
                'sub_menu' => [
                    [
                        'name' => 'Pemasukan',
                        'url' => url('/transactions/pemasukan'),
                        'sub_menu' => [],
                    ],
                    [
                        'name' => 'Pengeluaran',
                        'url' => url('/transactions/pengeluaran'),
                        'sub_menu' => [],
                    ],
                    [
                        'name' => 'Transfer',
                        'url' => url('/transactions/transfer'),
                        'sub_menu' => [],
                    ],
                ]
            ],
            [
                'name' => 'Reports',
                'url' => '',
                'sub_menu' => [
                    [
                        'name' => 'Laporan Anggota',
                        'url' => url('/reports/anggota'),
                        'sub_menu' => []
                    ],
                ]
            ]
        ];

        return view('components.sidebar', ['menu' => $menu]);
    }
}
