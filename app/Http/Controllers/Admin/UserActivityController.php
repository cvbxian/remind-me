<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function create(User $user)
    {
        return view('admin.activities.form', [
            'activity' => new Activity(),
            'user'     => $user,
        ]);
    }

    public function store(Request $request, User $user)
    {
        $user->activities()->create($this->validated($request));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Activity added for ' . $user->name . '.');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.form', [
            'activity' => $activity,
            'user'     => $activity->user,
        ]);
    }

    public function update(Request $request, Activity $activity)
    {
        $activity->update($this->validated($request));

        return redirect()->route('admin.users.show', $activity->user_id)
            ->with('success', 'Activity updated.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return back()->with('success', 'Activity deleted.');
    }

    public function toggleDone(Activity $activity)
    {
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
}