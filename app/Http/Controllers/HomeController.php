<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\TimeBreak;
use App\Models\User;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
    {
        $this->middleware(['rolepermission:view-tele-marketer-console'], ['only' => ['teleMarketerConsole']]);
        $this->middleware(['rolepermission:view-reception'], ['only' => ['reception']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->hasRole('TELE MARKETER')) {
            return redirect(route('tele_console'));
        }

        if ($user->hasRole('RECEPTION')) {
            return redirect(route('reception'));
        }

        return view('home');
    }

    public function teleMarketerConsole()
    {
        /** @var User $user */
        $user = auth()->user();
        $lead = new Lead();

        $lastLoginTime   = $user->last_login;
        $diffTime        = now()->diffAsCarbonInterval($lastLoginTime);
        $diffLoginString = "{$diffTime->h}:{$diffTime->i}:{$diffTime->s}";

        $lastBreakTime   = TimeBreak::whereNotNull('start_break')->whereNull('end_break')->whereDate('start_break', Carbon::today())->latest()->first();
        $diffBreakString = $maxBreakTime = $startBreakValue = '';

        if ($lastBreakTime) {
            $maxBreakTime    = $lastBreakTime->reason_break->time_alert * 60;
            $totalTimeBreak  = TimeBreak::whereDate('start_break', Carbon::today())->get()->sum(function (TimeBreak $timeBreak) {
                if ($timeBreak->end_break) {
                    return $timeBreak->end_break->diffInSeconds($timeBreak->start_break);
                }

                return now()->diffInSeconds($timeBreak->start_break);
            });
            $diffBreakString = gmdate('H:i:s', $totalTimeBreak);

            if ($diffBreakString) {
                $startBreakValue = $totalTimeBreak;
            } else {
                $diffTime        = now()->diffAsCarbonInterval($lastBreakTime->start_break);
                $diffBreakString = "{$diffTime->h}:{$diffTime->i}:{$diffTime->s}";
            }
        } else {
            $lead = Lead::where('user_id', $user->id)->first();
            $lead = $lead ?? Lead::getAvailable()->first();
            if ($lead) {
                $lead->update([
                    'call_date' => now()->toDateTimeString(),
                    'user_id'   => auth()->id(),
                ]);
            }
        }

        return view('tele_marketer_console', compact('lead', 'diffLoginString', 'diffBreakString', 'maxBreakTime', 'startBreakValue'));
    }

    public function reception()
    {
        $lead = Lead::find(1);

        return view('reception_console', ['lead' => $lead]);
    }

    public function lang()
    {
        $lang    = config('app.locale');
        $strings = \File::get(resource_path("lang/{$lang}.json"));
        header('Content-Type: text/javascript');
        echo('window.lang = ' . $strings . ';');
        exit();
    }

    public function quickSearch()
    {
        $query   = request()->get('query');
        $results = [];
        if ($query) {
            $results = \App\Models\QuickSearch::search($query)->get()->map(function ($elem) {
                return [
                    'text' => $elem['search_text'],
                    'url'  => $elem['route'],
                ];
            })->toArray();
        }

        return view('layouts.partials.quicksearch_result')->with('results', $results);
    }
}
