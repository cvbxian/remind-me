<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->activities();

        $today = (clone $query)->whereDate('activity_date', today())
            ->orderBy('activity_time')->get();

        $upcoming = (clone $query)->whereDate('activity_date', '>', today())
            ->orderBy('activity_date')->orderBy('activity_time')->get();

        return view('activities.index', compact('today', 'upcoming'));
    }

    public function create()
    {
        return view('activities.form', ['activity' => new Activity()]);
    }

    public function store(Request $request)
    {
        $request->user()->activities()->create($this->validated($request));

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        $this->authorizeOwner($activity);
        return view('activities.form', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $this->authorizeOwner($activity);
        $activity->update($this->validated($request));

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $this->authorizeOwner($activity);
        $activity->delete();

        return back()->with('success', 'Activity deleted.');
    }

    public function toggleDone(Activity $activity)
    {
        $this->authorizeOwner($activity);
        $activity->status = $activity->status === 'done' ? 'pending' : 'done';
        $activity->save();

        return back();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'         => ['required', 'string', 'max:150'],
            'description'   => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'activity_time' => ['required', 'date_format:H:i'],
            'remind_before' => ['required', 'integer', 'in:0,5,10,30,60,1440'],
        ]);
    }

    private function authorizeOwner(Activity $activity): void
    {
        abort_unless($activity->user_id === Auth::id(), 403);
    }
}