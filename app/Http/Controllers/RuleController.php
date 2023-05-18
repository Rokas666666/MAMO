<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$lessons = Lesson::all();
        //return view('lesson.index')->with('lessons', $lessons);

        $rules = Rule::all();
        return view('rule.index')->with('rules', $rules);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = $this->selectTeachers();
        return view('rule.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Create lesson
        $rule = new Rule;
        $rule->dateFrom = $request->input('dateFrom');
        $rule->dateTo = $request->input('dateTo');
        $rule->restriction = $request->input('restriction');
        $rule->userID = $request->input('userID');
        $rule->school_id = Auth::user()->school_id;
        $rule->save();

        return redirect('/rule')->with('success', 'Taisykle sukurta');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rule = Rule::find($id);
        $user = User::find($rule->userID);
        return view('rule.show')->with(compact('rule', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rule = Rule::find($id);
        $teachers = $this->selectTeachers();
        return view('rule.edit')->with(compact('rule', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Create lesson
        $rule = Rule::find($id);
        $rule->dateFrom = $request->input('dateFrom');
        $rule->dateTo = $request->input('dateTo');
        $rule->restriction = $request->input('restriction');
        $rule->userID = $request->input('userID');
        $rule->save();

        return redirect('/rule')->with('success', 'Taisykle issaugota');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rule = Rule::find($id);
        $rule->delete();
        return redirect('/rule')->with('success', 'Taisykle panaikinta');
    }

    public function selectTeachers()
    {
        $teachers = User::where('role', 2)
                        ->where('school_id', Auth::user()->school_id)
                        ->get()
                        ->pluck('name', 'id');
        return $teachers;
    }
}
