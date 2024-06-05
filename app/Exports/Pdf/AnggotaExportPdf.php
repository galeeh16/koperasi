<?php

namespace App\Exports\Pdf;

use Mpdf\Mpdf;
use App\Models\Anggota;

class AnggotaExportPdf
{
    public function __construct(
        private string $title
    ) {}

    public function make(): string
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'orientation' => 'L'
        ]);
        // $mpdf->use_kwt = true;
        $mpdf->SetTitle($this->title);

        // Define the Header/Footer before writing anything so they appear on the first page
        $mpdf->SetHTMLHeader('
            <div style="text-align: right; font-weight: bold;">
                {PAGENO}/{nbpg}
            </div>');

        // $mpdf->SetHTMLFooter('
        // <table width="100%">
        //     <tr>
        //         <td width="33%">FOOTER</td>
        //         <td width="33%" style="text-align: right;">My document</td>
        //     </tr>
        // </table>');

        $data = $this->getData();

        // Buffer the following html with PHP so we can store it to a variable later
        ob_start();
        // This is where your script would normally output the HTML using echo or print
        echo $this->buildHTML($data);

        // Now collect the output buffer into a variable
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf->WriteHTML($html);
        $filename = $this->title . '.pdf';

        $mpdf->Output($filename);
        return $filename;
    }

    private function getData(): \Generator
    {
        $data = Anggota::query()->cursor();

        foreach ($data as $data) {
            yield $data;
        }
    }

    private function buildHTML(\Generator $data): string
    {
        $html = <<<'HTML'
            <style>
                html, body {
                    font-family: 'Arial', sans-serif;
                    font-size: 13px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table thead tr th,
                table tbody tr td {
                    padding: 4px 2px;
                    border: 1px solid #555;
                    vertical-align: text-top;
                }
            </style>
        HTML;

        $html .= <<<EOL
            <h2>Data Anggota</h2>

            <table>
                <thead>
                    <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>No Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Registrasi</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Status Menikah</th>
                    <th>Departemen</th>
                    <th>Pekerjaan</th>
                    <th>Agama</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>No Handphone</th>
                    <th>Aktif Keanggotaan</th>
                    <th>Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
        EOL;

        $no = 1;
        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td>' . ($no++) . '</td>';
            $html .= '<td>' . $row->username . '</td>';
            $html .= '<td>' . $row->no_anggota . '</td>';
            $html .= '<td>' . $row->nama_lengkap . '</td>';
            $html .= '<td>' . $row->tanggal_registrasi . '</td>';
            $html .= '<td>' . $row->jenis_kelamin . '</td>';
            $html .= '<td>' . $row->tempat_lahir . '</td>';
            $html .= '<td>' . $row->tanggal_lahir . '</td>';
            $html .= '<td>' . $row->status_menikah . '</td>';
            $html .= '<td>' . $row->departemen . '</td>';
            $html .= '<td>' . $row->pekerjaan . '</td>';
            $html .= '<td>' . $row->agama . '</td>';
            $html .= '<td>' . $row->alamat . '</td>';
            $html .= '<td>' . $row->kota . '</td>';
            $html .= '<td>' . $row->no_hp . '</td>';
            $html .= '<td>' . $row->aktif_keanggotaan . '</td>';
            $html .= '<td>' . $row->status_peminjaman . '</td>';
            $html .= '</tr>';
        }

        $html .= <<<EOL
                </tbody>
            </table>
        EOL;

        return $html;
    }
}
