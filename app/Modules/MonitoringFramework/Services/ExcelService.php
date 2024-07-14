<?php

namespace App\Modules\MonitoringFramework\Services;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelService implements WithTitle, ShouldAutoSize, FromView, ShouldQueue, withEvents
{
    use Exportable;

    private $master_data;

    public function __construct($master_data)
    {
        $this->master_data = $master_data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Excel';
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $master_data = $this->master_data;

        if (isset($master_data->sourceType)) {
            $data = $master_data->data;
            $data['source'] = $master_data->source;
            return view("MonitoringFramework::excel_summary", $data);
        } else if (isset($master_data->scoreType)) {
            return view('Goals::goal_tracking_view', compact('master_data'));
        } else {

            return view("MonitoringFramework::excel", compact('master_data'));
        }


    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [AfterSheet::class => function (AfterSheet $event) {
            $cellRange = 'A1:Z1';
            $getHighestRow = $event->sheet->getDelegate()->getHighestRow();
            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            $event->sheet->getDelegate()->getStyle('A1:Z' . $getHighestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }];
    }
}
