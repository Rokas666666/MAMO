<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Room;
use App\Models\Timetable;
use App\Models\Timeslot;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$lessons = Lesson::all();
        //return view('lesson.index')->with('lessons', $lessons);

        $userID = Auth::id();
        $lessons = Lesson::join("modules", "lessons.module_id", "=", "modules.id")
                         ->select("modules.user_id as user_id", "lessons.*")
                         ->where('user_id', $userID)
                         ->orderBy('time', "asc")
                         ->get();

        return view('lesson.index')->with('lessons', $lessons);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::where('user_id', Auth::id())->get();
        $rooms = Room::where('school_id', Auth::user()->school_id)->get();
        $timeslots = Timeslot::all();
        return view('lesson.create', compact('modules', 'rooms', 'timeslots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Consider using the laravel-ckeditor for things like bold text
        //7th video end describes how

        $this->validate($request, [
            'time' => 'required',
        ]);

        $date = $request->input('date');
        $time = $request->input('time');

        //Create lesson
        $lesson = new Lesson;
        $lesson->module_id = $request->input('module_id');
        $lesson->room_id = $request->input('room_id');
        $lesson->time = date('Y-m-d H:i', strtotime("$date $time"));
        $lesson->comment = $request->input('comment');
        $lesson->homework = $request->input('homework');
        $lesson->test = $request->input('test');
        $lesson->timeslot_id = $request->input('timeslot_id');

        $lesson->timetable_id = Timetable::orderBy('id', 'DESC')->first()->id; //HARDCODED ALERT HARDCODED ALERT HARDCODED ALERT HARDCODED ALERT

        $lesson->save();

        return redirect('/lesson')->with('success', 'Lesson created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::find($id);
        $moduleLesson = Module::find($lesson->module_id);
        $roomLesson = Room::find($lesson->room_id);
        $timeslotLesson = TimeSlot::find($lesson->timeslot_id);
        return view('lesson.show', compact('lesson', 'moduleLesson', 'roomLesson', 'timeslotLesson'));
        //return view('lesson.show')->with('lesson', $lesson);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lesson = Lesson::find($id);
        $modules = Module::all();
        $rooms = Room::all();
        $timeslots = Timeslot::all();
        $grades = Grade::where('lesson_id', $id)->get();
        foreach ($grades as $grade) {
            $user = User::find($grade->user_id);
            $grade->user_name = $user->name;
        }

        return view('lesson.edit', compact('lesson', 'modules', 'rooms', 'timeslots', 'grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'time' => 'required',
            'grade_values' => 'array', // Validate grade_values as an array
        ]);

        $date = $request->input('date');
        $time = $request->input('time');

        //Create lesson
        $lesson = Lesson::find($id);
        $lesson->module_id = $request->input('module_id');
        $lesson->room_id = $request->input('room_id');
        $lesson->time = date('Y-m-d H:i', strtotime("$date $time"));
        $lesson->comment = $request->input('comment');
        $lesson->homework = $request->input('homework');
        $lesson->test = $request->input('test');
        $lesson->save();

        $gradeValues = $request->input('grade_values');
        $grades = Grade::where('lesson_id', $id)->get();
        foreach ($gradeValues as $index => $gradeValue) {
            if ($grades[$index]) {
                $grades[$index]->value = $gradeValue;
                $grades[$index]->save();
            }
        }

        return redirect('/lesson')->with('success', 'Lesson updated (currently overwrites time)');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::find($id);
        $lesson->delete();
        return redirect('/lesson')->with('success', 'Lesson removed');
    }
}
