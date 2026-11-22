<?php

namespace App\Http\Controllers;

use App\Models\HijriMonth;
use App\Rules\PlainText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;

class HijriMonthController extends Controller
{
    /** API: confirmed month starts (public). Web: the admin page. */
    public function index()
    {
        $months = HijriMonth::orderByDesc('hijri_year')->orderByDesc('hijri_month')->get();

        if (REQ::is('api/*')) {
            return response()->json([
                'months' => $months->map(fn ($m) => [
                    'year' => $m->hijri_year,
                    'month' => $m->hijri_month,
                    'starts_on' => $m->starts_on->format('Y-m-d'),
                ])->values(),
            ], 200);
        }

        return view('others.hijri')->with('months', $months);
    }

    /** One entry per Hijri month: saving the same month again replaces its date. */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'hijri_year' => ['required', 'integer', 'between:1440,1500'],
            'hijri_month' => ['required', 'integer', 'between:1,12'],
            'starts_on' => ['required', 'date_format:Y-m-d', 'after:2019-01-01', 'before:2060-01-01'],
            'note' => ['nullable', 'string', 'max:160', new PlainText()],
        ]);

        HijriMonth::updateOrCreate(
            ['hijri_year' => $data['hijri_year'], 'hijri_month' => $data['hijri_month']],
            ['starts_on' => $data['starts_on'], 'note' => $data['note'] ?? null]
        );

        return back()->with('success', 'Imehifadhiwa: ' . HijriMonth::NAMES[(int) $data['hijri_month']] . ' ' . $data['hijri_year']);
    }

    public function destroy($id)
    {
        HijriMonth::whereKey($id)->delete();

        return back()->with('success', 'Imefutwa');
    }
}
