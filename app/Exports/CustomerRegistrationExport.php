<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerRegistrationExport implements FromView, ShouldAutoSize
{
    protected $records;

    public function __construct(array $records)
    {
        $this->records = $records;
    }

    public function view(): View {
        return view('customer-registration.export.excel', [
            'records' => $this->records,
        ]);
    }
}
