<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absen;
use App\Models\Logbook;
use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportingDaylogExportController extends Controller
{
    public function exportUserDetail($id)
    {
        $user = User::with(['division', 'category'])->findOrFail($id);
        $absences = Absen::with('absenHasPresensis')->where('user_id', $id)->orderBy('date', 'desc')->get();
        $logbooks = Logbook::where('user_id', $id)->orderBy('date', 'desc')->get();
        $pengajuans = Pengajuan::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('exports.reporting-daylog', compact('user', 'absences', 'logbooks', 'pengajuans'));
        return $pdf->download('user-report-'.$user->name.'-'.now()->format('YmdHis').'.pdf');
    }
}
