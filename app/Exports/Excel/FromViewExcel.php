<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class FromViewExcel implements FromView, WithProperties, ShouldAutoSize, WithEvents, WithChunkReading
{
    /** trait RegistersEventListeners */
    use RegistersEventListeners, Exportable;

    /** @var view, params, sheetName */
	public $view, $params, $sheetName;
	public static $locked;

    public function __construct(string $view='', array $params=[], string $sheetName='sheet1', bool $locked=false)
    {
		$this->view = $view;
		$this->params = $params;
		$this->sheetName = $sheetName;
		self::$locked = $locked;
	}

    public function view(): View
    {
        return view($this->view, $this->params);
    }

    /**
     * Untuk excel details
     *
     * @return array
     */
    public function properties(): array
    {
        return [
            'creator'        => 'Koperasi Digital',
            'title'          => $this->sheetName,
            'description'    => 'Koperasi Digital',
            'keywords'       => 'export,spreadsheet',
            'manager'        => 'Kopearsi Digital',
            'company'        => 'Kopearsi Digital',
        ];
    }

    /**
     * Event gets raised at the end of the sheet process.
     *
     * @param  AfterSheet $event
     */
    public static function afterSheet(AfterSheet $event)
    {
        if(self::$locked) {
        	$protection = $event->sheet->getProtection();
	        $protection->setPassword(config('excel.password'));
	        $protection->setSheet(true);
	        $protection->setSort(true);
	        $protection->setSelectLockedCells(true);
	        $protection->setSelectUnlockedCells(true);
        }
    }

    /**
     * Chunk
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
