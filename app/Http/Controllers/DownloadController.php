<?php

namespace App\Http\Controllers;

use App\Exports\CompanyDataExport;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    public function downloadXlsx()
    {
        return Excel::download(new CompanyDataExport, 'data.xlsx');
    }
}
