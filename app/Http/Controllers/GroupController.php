<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$lessons = Lesson::all();
        //return view('lesson.index')->with('lessons', $lessons);

        $groups = Group::where("school_id", Auth::user()->school_id)->get();
        return view('group.index')->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roleNumber = 1; // mokiniai
        $users = User::where('role', $roleNumber)->get();
        return view('group.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Create
        $group = new Group;
        $group->title = $request->input('title');
        $group->school_id = Auth::user()->school_id;
        $group->save();


        // Attach selected users
        $users = $request->input('users');
        $group->users()->attach($users);

        return redirect('/group')->with('success', 'Group');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::find($id);
        return view('group.show')->with('group', $group);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = Group::find($id);
        $users = User::whereHas('groups', function ($query) use ($group) {
            $query->where('id', $group->id);
        })->where('role', 1)->get();

        return view('group.edit')->with('group', $group)->with('users', $users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the group
        $group = Group::find($id);

        // Update the group's title
        $group->title = $request->input('title');
        $group->save();

        // Get the array of checked user IDs from the form
        $checkedUsers = $request->input('users', []);

        // Sync the users with the group (add/remove users based on the checkbox status)
        $group->users()->sync($checkedUsers);

        return redirect('/group')->with('success', 'Group updated (currently overwrites time)');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::find($id);
        $group->delete();
        return redirect('/group')->with('success', 'Group removed');
    }
}
