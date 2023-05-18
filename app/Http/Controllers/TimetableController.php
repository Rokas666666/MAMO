<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\User;
use App\Models\Timeslot;
use App\Models\Lesson;
use App\Models\Rule;
use App\Models\Module;

use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;


class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$lessons = Lesson::all();
        //return view('lesson.index')->with('lessons', $lessons);

        $timetables = Timetable::where("school_id", Auth::user()->school_id)->get();
        return view('timetable.index')->with('timetables', $timetables);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('timetable.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teachers = User::where('school_id', Auth::user()->school_id)
                        ->where('role', 2)
                        ->get();

        $timeslots = Timeslot::where('school_id', Auth::user()->school_id)->get();

        $modules = Module::join('users', 'modules.user_id', '=', 'users.id')
                         ->select('modules.id as id', 'hours', 'users.id as user_id', 'title', 'group_id')
                         ->where('users.school_id', Auth::user()->school_id)
                         ->get();

        $rules = Rule::where('school_id', Auth::user()->school_id)->get();

        $grupes = [];

        //Create timetable
        $timetable = new Timetable;
        $timetable->year = $request->input('year');
        $timetable->school_id = Auth::user()->school_id;
        //$timetable->save();

        //Sugeneruoti tuščią pamokų matricą
        $Matrix = [];
        for ($i = 0; $i < count($teachers); $i++){
            $teachersWeek = [];
            for ($j = 0; $j < count($timeslots)*5; $j++){
                $teachersWeek[$j] = -1;
            }
            $Matrix[$teachers[$i]->id] = $teachersWeek;
        }

        //Atsitiktinai sudelioti pamokas
        //Paimam po vieną modulį
        for ($i = 0; $i < count($modules); $i++){
            $modulis = $modules[$i];
            $mokytojas = $modulis->user_id;
            $pamokuSkc = $modulis->hours;
            //Modulį įdedam tiek kartų, kiek turi būti per savaitę
            for ($j = 0; $j < $pamokuSkc; $j++){
                $success = false;
                //einam per visus timeslotus
                for ($k = 0; $k < count($timeslots)*5; $k++){
                    //jei tuščias, įdedam pamoką
                    if ($Matrix[$mokytojas][$k] == -1){
                        $success = true;
                        $Matrix[$mokytojas][$k] = $modulis->id;
                        break;
                    }
                }
                if ($success == false){
                    echo "Netilpo visos pamokos";
                }
            }
        }

        //Įvertinti tvarkaraštį
        $score = 0;

        for ($i = 0; $i < count($rules); $i++){
            
        }

        for ($i = 0; $i < count($timeslots)*5; $i++){

        }

        //Echo matricą lentelėje
        $dienos = [0 => "pirmadienis",
                   1 => "antradienis",
                   2 => "treciadienis",
                   3 => "ketvirtadienis",
                   4 => "penktadienis"];
        $dayIndex = 0;

        echo "<table>";
        echo "<tr>";
        echo "<th>Laikas</th>";
        for ($i = 0; $i < count($teachers); $i++){
            echo "<th>".$teachers[$i]->name."</th>";
        }
        echo "</tr>";
        for ($j = 0; $j < count($timeslots)*5; $j++){
            if ($j % count($timeslots) == 0){
                echo "<tr><td>".$dienos[$dayIndex++]."</td></tr>";
            }
            echo "<tr>";
            echo "<td>".$timeslots[$j%count($timeslots)]->start."-".$timeslots[$j%count($timeslots)]->end()."</td>";
            for ($i = 0; $i < count($teachers); $i++){
                echo "<td>".$Matrix[$teachers[$i]->id][$j]."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        

        #return redirect('/timetable')->with('success', "Sukurta sėkmingai");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $timetable = Timetable::find($id);
        return view('timetable.show')->with('timetable', $timetable);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $timetable = Timetable::find($id);
        return view('timetable.edit')->with('timetable', $timetable);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Create lesson
        $timetable = Timetable::find($id);
        $timetable->year = $request->input('year');
        $timetable->save();

        return redirect('/timetable')->with('success', 'Tvarkarastis issaugotas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timetable = Timetable::find($id);
        $timetable->delete();
        return redirect('/timetable')->with('success', 'Tvarkarastis panaikintas');
    }
}
