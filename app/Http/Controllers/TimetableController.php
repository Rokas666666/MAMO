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

        $modSpeed = $request->input("mod_speed");
        $iter = $request->input("iter");


        //Create timetable
        $timetable = new Timetable;
        $timetable->year = $request->input('year');
        $timetable->school_id = Auth::user()->school_id;

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
        $score = $this->evaluateTimetable($Matrix, $rules, $timeslots, $teachers);

        echo $score;

        $this->echoTimetable($Matrix, $teachers, $timeslots);

        for ($i = 0; $i < $iter; $i++){
            $modifiedMatrix = $this->modifyMatrix($Matrix, $teachers, $timeslots, $modSpeed);
            $modifiedScore = $this->evaluateTimetable($modifiedMatrix, $rules, $timeslots, $teachers);
            //echo $modifiedScore;
            //$this->echoTimetable($modifiedMatrix, $teachers, $timeslots);
            if ($modifiedScore > $score){
                $Matrix = $modifiedMatrix;
            }
        }

        //Įvertinti tvarkaraštį
        $score = $this->evaluateTimetable($Matrix, $rules, $timeslots, $teachers);

        echo $score;

        $this->echoTimetable($Matrix, $teachers, $timeslots);
        
        $this->saveTimetable($Matrix, $teachers, $timeslots, $timetable);

        echo "<a href='/timetable'>Baigta</a>";
        #return redirect('/timetable')->with('success', "Sukurta sėkmingai");
    }

    private function saveTimetable($Matrix, $teachers, $timeslots, $timetable){
        $timetable->save();

        for ($i = 0; $i < count($teachers); $i++){
            for ($j = 0; $j < count($timeslots)*5; $j++){
                if ($Matrix[$teachers[$i]->id][$j] == -1){
                    continue;
                }
                $lesson = new Lesson;
                $timeslot = $timeslots[$j%count($timeslots)];

                $day = intdiv($j,count($timeslots));
                $date = new \DateTime($timetable->year);

                if ($day > 0){
                    $date->modify("+".$day." day");
                }
                $time = \DateTime::createFromFormat('H:i:s', $timeslot->start);
                $combinedDateTime = $date->format('Y-m-d') . ' ' . $time->format('H:i:s');
                $combinedDateTimeObj = \DateTime::createFromFormat('Y-m-d H:i:s', $combinedDateTime);
                $lesson->time = $combinedDateTimeObj;
                
                $lesson->module_id = $Matrix[$teachers[$i]->id][$j];
                $lesson->room_id = 2; //<- pakeisti :)
                $lesson->timetable_id = $timetable->id;
                $lesson->timeslot_id = $timeslots[$j%count($timeslots)]->id;
                $lesson->comment = "";
                $lesson->homework = "";
                $lesson->test = "";
                $lesson->save();
            }
        }
    }

    private function modifyMatrix($Matrix, $teachers, $timeslots, $modifyCount){
        $newMatrix = $Matrix;
        for ($i = 0; $i < $modifyCount; $i++){
            while(true){
                $teacher = rand(0,(count($teachers)-1));
                $teacher = $teachers[$teacher];
                $time1 = rand(0, (count($timeslots)*5)-1);
                $time2 = rand(0, (count($timeslots)*5)-1);
                if ($newMatrix[$teacher->id][$time1] != -1 || $newMatrix[$teacher->id][$time2] != -1){
                    //echo "swapinu ".$time1." ir ".$time2;
                    $temp = $newMatrix[$teacher->id][$time1];
                    $newMatrix[$teacher->id][$time1] = $newMatrix[$teacher->id][$time2];
                    $newMatrix[$teacher->id][$time2] = $temp;
                    break;
                }
            }
        }
        //$this->echoTimetable($newMatrix, $teachers, $timeslots);
        return $newMatrix;
    }

    private function echoTimetable($Matrix, $teachers, $timeslots){
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
    }

    private function evaluateTimetable($Matrix, $rules, $timeslots, $teachers){
        $score = 0;
        
        //įvertinti taisykles
        for ($i = 0; $i < count($rules); $i++){
            $rule = $rules[$i];
            $user = $rule->userID;
            $restriction = intval($rule->restriction);
            if ($restriction < 5 && $restriction >= 0){
                for ($j = $restriction*count($timeslots); $j < $restriction*count($timeslots)+count($timeslots); $j++){
                    if ($Matrix[$user][$j] != -1){
                        $score -= 5000;
                    }
                }
            }
        }

        // //Stengtis kad pamokos nebūtų išmėtytos per visas dienas
        // for ($diena = 0; $diena < 5; $diena++){
        //     for ($i = 0; $i < count($teachers); $i++){
        //         $penalty = 0;
        //         $id = $teachers[$i]->id;
        //         for ($j = 0; $j < count($timeslots); $j++){
        //             if ($Matrix[$id][$diena*count($timeslots) + $j] != -1){
        //                 $penalty = -50;
        //             }
        //         }
        //         $score += $penalty;
        //     }    
        // }

        for ($diena = 0; $diena < 5; $diena++){
            for ($i = 0; $i < count($teachers); $i++){
                $id = $teachers[$i]->id;
                $hasLesson = false;
                $emptySlots = 0;
                for ($j = 0; $j < count($timeslots); $j++){
                    if ($Matrix[$id][$diena*count($timeslots) + $j] != -1){
                        $hasLesson = true;
                    }
                    else{
                        $emptySlots++;
                    }
                }
                if ($hasLesson){
                    $score -= $emptySlots*20;
                }
            }    
        }
        return $score;
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

        $lessons = Lesson::where('timetable_id', $id);
        $lessons->delete();

        $timetable->delete();
        return redirect('/timetable')->with('success', 'Tvarkarastis panaikintas');
    }
}
