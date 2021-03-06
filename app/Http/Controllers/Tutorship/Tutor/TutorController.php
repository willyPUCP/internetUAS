<?php

namespace Intranet\Http\Controllers\Tutorship\Tutor;

use Auth;
use Illuminate\Http\Request;
use Intranet\Http\Requests;
use Illuminate\Support\Facades\DB;
use Intranet\Http\Controllers\Controller;
use Intranet\Models\Teacher;
use Intranet\Models\TutSchedule;
use Intranet\Models\Tutorship;
use Intranet\Models\Tutstudent;
use Intranet\Models\Reason;
use Intranet\Models\TutMeeting;
use Illuminate\Support\Facades\Session; //<---------------------------------necesario para usar session

class TutorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $filters = $request->all();
        $specialty = Session::get('faculty-code');

        $tutors = Teacher::getTutorsFiltered($filters, $specialty);
        $tutors = $tutors->appends($filters);
        $horas = [];
        $alumnos = [];
        foreach ($tutors as $t) {
            $tutSchedule = TutSchedule::where('id_docente', $t->IdDocente)->get();
            $horas[$t->IdDocente] = $tutSchedule->count();

            $tutorship = Tutorship::where('id_tutor', $t->IdDocente)->get();
            $alumnos[$t->IdDocente] = $tutorship->count();
        }

        $data = [
            'tutors' => $tutors,
            'horas' => $horas,
            'alumnos' => $alumnos,
        ];

        return view('tutorship.tutor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $filters = $request->all();

        $specialty = Session::get('faculty-code');
        $teachers = Teacher::getCoordsFiltered($filters, $specialty);
        $data = [
            'teachers' => $teachers->appends($filters),
        ];

        return view('tutorship.tutor.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($request['check'] != null) {
            foreach ($request['check'] as $idTeacher => $value) {
                try {
                    //se cambia el rol del profesor a TUTOR
                    DB::table('Docente')->where('IdDocente', $idTeacher)->update(['rolTutoria' => 1]);
                } catch (Exception $e) {
                    return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
                }
            }
            return redirect()->route('tutor.index')->with('success', 'Se guardaron los tutores exitosamente');
        } else {
            return redirect()->route('tutor.index');
        }
        //VUELVE A la lista de tutores
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $tutor = Teacher::find($id);
        $tutSchedule = TutSchedule::where('id_docente', $tutor->IdDocente)->get();
        $horas = $tutSchedule->count();

        $data = [
            'tutor' => $tutor,
            'horas' => $horas,
        ];

        return view('tutorship.tutor.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    public function reassign($id) {

        $tutor = Teacher::find($id);
        $razones = Reason::where('tipo', 2)->get();
        $idEspecialidad = Session::get('faculty-code');
        $students = Tutstudent::where('id_especialidad', $idEspecialidad)->where('id_tutoria', '!=', null)->get();
        $tutors = Teacher::where('IdEspecialidad', $idEspecialidad)->where('rolTutoria', 1)->where('IdDocente', '!=', $id)->get();

        $horas = [];
        foreach ($tutors as $t) {
            $tutSchedule = TutSchedule::where('id_docente', $t->IdDocente)->get();
            $horas[$t->IdDocente] = $tutSchedule->count();
        }

        $data = [
            'tutor' => $tutor,
            'razones' => $razones,
            'students' => $students,
            'tutors' => $tutors,
            'horas' => $horas,
        ];

        return view('tutorship.tutor.reassign', $data);
    }

    public function deactivate(Request $request, $id) {
        $sum = 0;
        if ($request['cant'] != null && $request['total'] != 0) {
            foreach ($request['cant'] as $idTeacher => $value) {
                $sum = $sum + $value;
            }
            if ($sum != $request['total']) {
                return redirect()->back()->with('warning', 'Los campos deben sumar el total de alumnos a reasignar.');
            } else {
                try {
                    //cambiar tutor principal y ponerles tutor suplente
                    foreach ($request['cant'] as $idTeacher => $cantAlumnos) {
                        $tutorships = Tutorship::where('id_tutor', $id)->take($cantAlumnos)->get();
                        foreach ($tutorships as $t) {
                            $tutorship = Tutorship::find($t->id);
                            $tutorship->id_tutor = $idTeacher;
                            $tutorship->id_suplente = $idTeacher;
                            $tutorship->save();

                            $citas = TutMeeting::where('id_tutstudent', $t->id_alumno)->where('id_docente', $t->id_tutor)->where('estado', 'Confirmada')->get();
                            if ($citas->count() != 0) {
                                foreach ($citas as $c) {
                                    $cita = TutMeeting::find($c->id);
                                    $cita->estado = 'Cancelada';
                                    $cita->id_reason = $request['motivo'];
                                    $cita->save();
                                }
                            }
                        }
                    }
                    DB::table('Docente')->where('IdDocente', $id)->update(['rolTutoria' => 3]);
                } catch (Exception $e) {
                    return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
                }
            }
            return redirect()->route('tutor.index')->with('success', 'Se reasignaron tutores a: (' . $request['total'] . ') alumnos.');
        } else {
            return redirect()->route('tutor.index')->with('warning', 'No se puede hacer la reasignación.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) { //PENDIENTE PARA REASIGNAR
        try {
            DB::table('Docente')->where('IdDocente', $id)->update(['rolTutoria' => 3]);
            return redirect()->route('tutor.index')->with('success', 'Se desactivó al tutor exitosamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
        }
    }

    // muestra el perfil del tutor que accede a sus datos
    public function myprofile() {
        $tutor = Auth::user()->professor;
        // dd($tutor);
        $data = [
            'tutor' => $tutor,
        ];

        return view('tutorship.tutor.myprofile', $data);
    }

}
