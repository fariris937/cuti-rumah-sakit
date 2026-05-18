<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Ijin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class KepalaKepegawaianController extends Controller
{
    /**
     * Dashboard kepala kepegawaian menampilkan laporan cuti karyawan
     */
    public function index(Request $request)
    {
        $kepalaKepegawaian = Auth::user();

        // Ambil karyawan yang berada di bawah kepala kepegawaian
        // Asumsi: kepala kepegawaian melihat semua karyawan (role karyawan)
        $users = User::where('role', 'karyawan')->with(['unitAktif', 'divisi'])->get();

        // Ambil semua cuti yang sudah disetujui oleh kepala bagian atau kepala ruangan
        $cutiYear = $request->input('cuti_year', now()->format('Y'));
        $cutiMonth = $request->input('cuti_month', now()->format('m'));
        $cutiDay = $request->input('cuti_day');

        $cutisQuery = Cuti::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_bagian')
                      ->orWhereNotNull('disetujui_oleh_kepala_ruangan');
            })
            ->with(['user', 'disetujuiOlehKepalaBagian', 'disetujuiOlehKepalaRuangan'])
            ->orderByDesc('updated_at');

        $cutisQuery->whereYear('tanggal_mulai', $cutiYear)
                   ->whereMonth('tanggal_mulai', $cutiMonth);

        if ($cutiDay) {
            $cutisQuery->whereDay('tanggal_mulai', $cutiDay);
        }

        $cutis = $cutisQuery->get();

        // Ambil semua ijin yang sudah disetujui oleh kepala ruangan atau kepala bagian
        $ijinYear = $request->input('ijin_year', now()->format('Y'));
        $ijinMonth = $request->input('ijin_month', now()->format('m'));
        $ijinDay = $request->input('ijin_day');

        $ijinsQuery = Ijin::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_ruangan')
                      ->orWhereNotNull('disetujui_oleh_kepala_bagian');
            })
            ->with(['user', 'disetujuiOlehKepalaRuangan', 'disetujuiOlehKepalaBagian'])
            ->orderByDesc('updated_at');

        $ijinsQuery->whereYear('tanggal_ijin', $ijinYear)
                   ->whereMonth('tanggal_ijin', $ijinMonth);

        if ($ijinDay) {
            $ijinsQuery->whereDay('tanggal_ijin', $ijinDay);
        }

        $ijins = $ijinsQuery->get();

        // Ambil filter overtime dari request
        $overtimeYear = $request->input('overtime_year', now()->format('Y'));
        $overtimeMonth = $request->input('overtime_month', now()->format('m'));
        $overtimeDay = $request->input('overtime_day');

        // Ambil lembur yang sudah disetujui oleh kepala ruangan dengan filter
        $overtimeQuery = \App\Models\Overtime::where('status', 'approved')
            ->whereYear('tanggal', $overtimeYear)
            ->whereMonth('tanggal', $overtimeMonth);

        if ($overtimeDay) {
            $overtimeQuery->whereDay('tanggal', $overtimeDay);
        }

        $overtimeApproved = $overtimeQuery->with(['user', 'user.divisi'])
            ->orderByDesc('updated_at')
            ->get();

        // Laporan Cuti Bulanan (Bulan Saat Ini)
        $monthlyTotalDays = 0;
        foreach ($cutis as $cuti) {
            $monthlyTotalDays += $cuti->tanggal_mulai->diffInDays($cuti->tanggal_selesai) + 1;
        }

        $monthlyReports = [
            'month' => \DateTime::createFromFormat('!m', $cutiMonth)->format('M Y'),
            'total_leaves' => $cutis->count(),
            'total_days' => $monthlyTotalDays,
            'year' => $cutiYear,
            'month_num' => $cutiMonth
        ];

        // Rekap Cuti Tahunan (Tahun Saat Ini)
        $annualCutiYear = $request->input('annual_cuti_year', now()->format('Y'));

        $annualCutis = Cuti::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_bagian')
                      ->orWhereNotNull('disetujui_oleh_kepala_ruangan');
            })
            ->whereYear('tanggal_mulai', $annualCutiYear)
            ->get();

        $annualTotalDays = 0;
        foreach ($annualCutis as $cuti) {
            $annualTotalDays += $cuti->tanggal_mulai->diffInDays($cuti->tanggal_selesai) + 1;
        }

        $annualReports = [
            'year' => $annualCutiYear,
            'total_leaves' => $annualCutis->count(),
            'total_days' => $annualTotalDays
        ];

        // Debug: cek data overtime
        Log::info('Overtime data count: ' . $overtimeApproved->count());
        Log::info('Overtime data: ' . json_encode($overtimeApproved->toArray()));

        return view('kepala_kepegawaian.dashboard', compact('cutis', 'ijins', 'users', 'kepalaKepegawaian', 'monthlyReports', 'annualReports', 'overtimeApproved'));
    }

    /**
     * Download laporan cuti bulanan dalam format PDF
     */
    public function downloadMonthly(Request $request)
    {
        $currentMonth = $request->input('month', now()->format('m'));
        $currentYear = $request->input('year', now()->format('Y'));
        $currentDay = $request->input('day');

        $monthlyCutisQuery = Cuti::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_bagian')
                      ->orWhereNotNull('disetujui_oleh_kepala_ruangan');
            })
            ->whereYear('tanggal_mulai', $currentYear)
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->with(['user', 'disetujuiOlehKepalaBagian', 'disetujuiOlehKepalaRuangan', 'user.unitAktif', 'user.units']);

        if ($currentDay) {
            $monthlyCutisQuery->whereDay('tanggal_mulai', $currentDay);
        }

        $monthlyCutis = $monthlyCutisQuery->get();

        $totalDays = 0;
        foreach ($monthlyCutis as $cuti) {
            $totalDays += $cuti->tanggal_mulai->diffInDays($cuti->tanggal_selesai) + 1;
        }

        $data = [
            'title' => 'Laporan Cuti Bulanan',
            'period' => \DateTime::createFromFormat('!m', $currentMonth)->format('M') . ' ' . $currentYear,
            'cutis' => $monthlyCutis,
            'total_leaves' => $monthlyCutis->count(),
            'total_days' => $totalDays,
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('kepala_kepegawaian.pdf.monthly_report', $data);
        $filename = "laporan_cuti_bulanan_{$currentMonth}_{$currentYear}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Download rekap cuti tahunan dalam format PDF
     */
    public function downloadAnnual(Request $request)
    {
        $currentYear = $request->input('year', now()->format('Y'));

        $annualCutis = Cuti::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_bagian')
                      ->orWhereNotNull('disetujui_oleh_kepala_ruangan');
            })
            ->whereYear('tanggal_mulai', $currentYear)
            ->with(['user', 'disetujuiOlehKepalaBagian', 'disetujuiOlehKepalaRuangan', 'user.unitAktif', 'user.units'])
            ->get();

        $totalDays = 0;
        foreach ($annualCutis as $cuti) {
            $totalDays += $cuti->tanggal_mulai->diffInDays($cuti->tanggal_selesai) + 1;
        }

        $data = [
            'title' => 'Rekap Cuti Tahunan',
            'year' => $currentYear,
            'cutis' => $annualCutis,
            'total_leaves' => $annualCutis->count(),
            'total_days' => $totalDays,
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('kepala_kepegawaian.pdf.annual_report', $data);
        $filename = "rekap_cuti_tahunan_{$currentYear}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Download laporan lembur bulanan dalam format PDF
     */
    public function downloadOvertime(Request $request)
    {
        $currentMonth = $request->input('month', now()->format('m'));
        $currentYear = $request->input('year', now()->format('Y'));

        $overtimeApproved = \App\Models\Overtime::where('status', 'approved')
            ->whereYear('tanggal', $currentYear)
            ->whereMonth('tanggal', $currentMonth)
            ->with(['user', 'user.divisi', 'approvedBy'])
            ->orderByDesc('tanggal')
            ->get();

        $data = [
            'title' => 'Laporan Lembur Bulanan',
            'period' => \DateTime::createFromFormat('!m', $currentMonth)->format('F') . ' ' . $currentYear,
            'overtimes' => $overtimeApproved,
            'total_overtimes' => $overtimeApproved->count(),
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('kepala_kepegawaian.pdf.overtime_report', $data);
        $filename = "laporan_lembur_bulanan_{$currentMonth}_{$currentYear}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Download laporan ijin bulanan dalam format PDF
     */
    public function downloadIjinMonthly(Request $request)
    {
        $currentMonth = $request->input('month', now()->format('m'));
        $currentYear = $request->input('year', now()->format('Y'));
        $currentDay = $request->input('day');

        $monthlyIjinsQuery = Ijin::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_ruangan')
                      ->orWhereNotNull('disetujui_oleh_kepala_bagian');
            })
            ->whereYear('tanggal_ijin', $currentYear)
            ->whereMonth('tanggal_ijin', $currentMonth)
            ->with(['user', 'disetujuiOlehKepalaRuangan', 'disetujuiOlehKepalaBagian', 'user.unitAktif', 'user.units'])
            ->orderByDesc('tanggal_ijin');

        if ($currentDay) {
            $monthlyIjinsQuery->whereDay('tanggal_ijin', $currentDay);
        }

        $monthlyIjins = $monthlyIjinsQuery->get();

        $data = [
            'title' => 'Laporan Ijin Bulanan',
            'period' => \DateTime::createFromFormat('!m', $currentMonth)->format('M') . ' ' . $currentYear,
            'ijins' => $monthlyIjins,
            'total_ijins' => $monthlyIjins->count(),
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('kepala_kepegawaian.pdf.ijin_monthly_report', $data);
        $filename = "laporan_ijin_bulanan_{$currentMonth}_{$currentYear}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Download rekap ijin tahunan dalam format PDF
     */
    public function downloadIjinAnnual(Request $request)
    {
        $currentYear = $request->input('year', now()->format('Y'));

        $annualIjins = Ijin::where(function($query) {
                $query->whereNotNull('disetujui_oleh_kepala_ruangan')
                      ->orWhereNotNull('disetujui_oleh_kepala_bagian');
            })
            ->whereYear('tanggal_ijin', $currentYear)
            ->with(['user', 'disetujuiOlehKepalaRuangan', 'disetujuiOlehKepalaBagian', 'user.unitAktif', 'user.units'])
            ->orderByDesc('tanggal_ijin')
            ->get();

        $data = [
            'title' => 'Rekap Ijin Tahunan',
            'year' => $currentYear,
            'ijins' => $annualIjins,
            'total_ijins' => $annualIjins->count(),
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('kepala_kepegawaian.pdf.ijin_annual_report', $data);
        $filename = "rekap_ijin_tahunan_{$currentYear}.pdf";

        return $pdf->download($filename);
    }
}
