<?php

namespace App\Exports;

use App\Model\Table\DownloadApps;
use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DownloadExport implements FromView
{
      protected $from_date;
      protected $to_date;

      function __construct($from_date,$to_date) {
              $this->from_date = $from_date;
              $this->to_date = $to_date;
      }
    public function view(): View
    {

      return view('report/export', [
          'datas' => DownloadApps::with(['endusers','apps'])->whereBetween('created_at',[ $this->from_date,$this->to_date])->get()
      ]);
    }
}
