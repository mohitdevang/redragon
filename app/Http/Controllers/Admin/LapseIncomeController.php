<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Wallet\LapseIncomeService;
use Illuminate\Support\Facades\DB;

class LapseIncomeController extends Controller
{
    public function index()
    {
        $data['total_lapse'] = app(LapseIncomeService::class)->totalLapseIncome();
        $data['rows'] = DB::table('lapse_income_transactions')
            ->orderByDesc('id')
            ->limit(500)
            ->get();

        return view('admin.lapse_income.index', $data);
    }
}
