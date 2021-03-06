<?php

namespace Intranet\Http\Controllers\Psp\Supervisor;

use Illuminate\Http\Request;

use Intranet\Http\Requests;
use Intranet\Http\Controllers\Controller;

use Intranet\Models\Supervisor;
use Intranet\Models\PspProcess;
use Intranet\Models\PspProcessxSupervisor;
use Intranet\Models\PspProcessxTeacher;
use Intranet\Models\Teacher;
use Intranet\Models\Teacherxgroup;
use Intranet\Models\User;
use Intranet\Models\Course;
use Illuminate\Support\Facades\DB;

use Session;
use Auth;

class ParticipationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User()->professor;
        $procesos = PspProcessxTeacher::where('iddocente',$user->IdDocente)->get();
        $process = DB::table('pspprocessesxdocente')->join('pspprocesses','idpspprocess','=','pspprocesses.id')->join('Curso','pspprocesses.idcurso', '=', 'Curso.IdCurso')->select('pspprocesses.id','Curso.Nombre')->where('pspprocessesxdocente.iddocente',$user->IdDocente)->lists('Nombre','id');
        
        $first_key = key($process);
        $primerProc = PspProcess::find($first_key);
        $supActivos = PspProcessxSupervisor::where('idpspprocess',$first_key)->get();

        $ids = [];
        foreach ($supActivos as $sup) {
            array_push($ids, $sup->id);
        }
        $supervisores = Supervisor::where('idfaculty',$primerProc->idespecialidad)->whereNotIn('id',$ids)->get();

        $data = [
            'supervisores'    =>  $supervisores,
            'procesos'      =>  $process,
            'supActivos'    =>  $supActivos,
        ];

        return view('psp.supervisor.index-participant',$data);
    }

    public function storeSupervisor(Request $request)
    {
        try {
            $faculty_id = Session::get('faculty-code'); 
            $process = PspProcess::where('idEspecialidad',$faculty_id)->first();

            $relation = new PspProcessxSupervisor;
            $relation->idPspProcess = $process->id;
            $relation->idSupervisor = $request['idSupervisor'];
            $relation->save();


            return redirect()->route('supervisor.index')->with('success', 'El supervisor se ha agregado exitosamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySupervisor($id)
    {
        try {
            $supervisor = PspProcessxSupervisor::find($id);

            if($supervisor){
                $group = Group::find($investigatorXgroup->id_grupo);
                $investigatorXgroup->delete();

                return redirect()->route('psp.supervisor.index-participant',$data)->with('success', 'El supervisor se ha quitado exitosamente');
            }else{
                return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');    
            }
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTeacher(Request $request)
    {
        try {
            $group = Group::find($request['id_group']);

            $group->teachers()->attach($request['id_docente']);

            return redirect()->route('grupo.edit',$group->id)->with('success', 'El profesor se ha agregado exitosamente');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTeacher($id)
    {
        try {
            $teacherXgroup = Teacherxgroup::find($id);

            if($teacherXgroup){
                $group = Group::find($teacherXgroup->id_grupo);
                $teacherXgroup->delete();

                return redirect()->route('grupo.edit',$group->id)->with('success', 'El profesor se ha quitado exitosamente');
            }else{
                return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');    
            }
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Ocurrió un error al hacer esta acción');
        }
    }
}
