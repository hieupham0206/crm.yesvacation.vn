<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\TimeBreak;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lead = Lead::getAvailable()->first();
        $lead->update(['call_date' => now()->toDateTimeString()]);

        $lead = $lead ?? new Lead();
        /** @var User $user */
        $user            = auth()->user();
        $lastLoginTime   = $user->last_login;
        $diffTime        = now()->diffAsCarbonInterval($lastLoginTime);
        $diffLoginString = "{$diffTime->h}:{$diffTime->i}:{$diffTime->s}";

        $lastBreakTime = TimeBreak::whereNotNull('start_break')->whereNull('end_break')->latest()->first();
        $diffBreakString = '';
        if ($lastBreakTime) {
            $diffTime        = now()->diffAsCarbonInterval($lastBreakTime->start_break);
            $diffBreakString = "{$diffTime->h}:{$diffTime->i}:{$diffTime->s}";
        }

        return view('tele_marketer_console', compact('lead', 'diffLoginString',  'diffBreakString'));
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
                    'url'  => $elem['route']
                ];
            })->toArray();
        }

        return view('layouts.partials.quicksearch_result')->with('results', $results);
    }

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
    {
    }
}
