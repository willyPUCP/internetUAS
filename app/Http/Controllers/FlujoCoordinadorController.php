<?php

namespace Intranet\Http\Controllers;

use Illuminate\Http\Request;

use Intranet\Http\Requests;
use Intranet\Models\criterion;

use Session;
use Intranet\Models\Faculty;
use Intranet\Models\EducationalObjetive;
use Intranet\Http\Requests\EducationalObjetiveRequest;

use Intranet\Http\Services\StudentsResult\StudentsResultService;
use Intranet\Http\Services\EducationalObjetive\EducationalObjetiveService;
use Intranet\Http\Services\Aspect\AspectService;
use Intranet\Http\Requests\AspectRequest;

use Intranet\Http\Requests\CriterioResquest;
use Intranet\Http\Requests\StudentResultRequest;

class FlujoCoordinadorController extends Controller
{
	protected $aspectService;
	protected $studentsResultService;
	protected $educationalObjetiveService;

	public function __construct() {
		$this->aspectService = new AspectService();
		$this->studentsResultService = new StudentsResultService();
		$this->educationalObjetiveService = new EducationalObjetive();
	}


    //
    public function aspect_index($id) {
		$data['title'] = 'Aspectos';
		try {			
			$studentResults= $this->studentsResultService->findByFaculty2($id);
			$data['studentsResults'] = $studentResults;
			$data['aspects'] = $this->aspectService->findByRE($studentResults);
            $data['idEspecialidad']=$id;
		} catch(\Exception $e) {
			dd($e);
		}
		return view('flujoCoordinador.aspect_index', $data);
	}

	public function aspect_create(AspectRequest $request, $id) {
	
			$data['title'] = 'Nuevo Aspecto';
			$data['resultado']=$this->studentsResultService->findById($request->all());
            $data['idEspecialidad']=$id;
			return view('flujoCoordinador.aspect_create', $data);
				
	}

	public function aspect_store(Request $request,$id) {
		try {
			$this->aspectService->create($request->all());
		} catch(\Exception $e) {
			dd($e);
		}
		return redirect()->route('aspect_index.flujoCoordinador',$id)->with('success', 'El aspecto se ha registrado exitosamente');
	}

    //Criterios
    public function criterio_index ($id){

		$especialidad = Faculty::findOrFail($id);
		$resultados = $especialidad->studentsResults;
		return view('flujoCoordinador.criterio_index', ['resultados'=>$resultados, 'idEspecialidad' =>$id]);
    	//return "profesor creado";
    }

    public function criterio_create (CriterioResquest $request, $id){
    	return 'crear criterio '.$id. ' '. $request->get('resultado'). ' '. $request->get('aspecto');
    	//return view('flujoCoordinador.criterio_create', ['idEspecialidad'=>$id]);
    }
    //Fin de criterio
    
    //objetivos educacionales
    public function objetivoEducacional_index ($id){

		$especialidad = Faculty::findOrFail($id);
		$objetivos = $especialidad->objectives;
		return view('flujoCoordinador.objetivoEducacional_index', ['objetivos'=>$objetivos, 'idEspecialidad' =>$id]);

    }

    public function objetivoEducacional_create ($id){
    	//return 'crear objetivo de la especialidad '.$id;
    	return view('flujoCoordinador.objetivoEducacional_create', ['idEspecialidad'=>$id]);
    }
    
    public function objetivoEducacional_store (EducationalObjetiveRequest $request, $id){

        //crear un nuevo objetivo educacional
        $numberOE = EducationalObjetive::where('IdEspecialidad',Session::get('faculty-code'))
									   ->where('deleted_at',null)->count();
		$numberOE = ($numberOE) + 1;
		$educationalObjetive = EducationalObjetive::create([
			'IdEspecialidad' => $id,
			'Numero' => $numberOE,
			'Descripcion' => $request->input('descripcion'),
			'Estado' => 1,
		]);

        return redirect()->route('objetivoEducacional_index.flujoCoordinador', ['id' => $id])
                            ->with('success', 'El objetivo educacional se ha registrado exitosamente');
    }

    public function studentResult_index($id){        

        $data['title'] = "Resultados Estudiantiles";
        $data['id'] = $id;
        try {
            $data['studentsResults'] = $this->studentsResultService->retrieveAllByFaculty($id);
            //dd($data['studentsResults']);
        } catch(\Exception $e) {
            redirect()->back()->with('warning','Ha ocurrido un erroaar'); 
        }
        
        return view('flujoCoordinador.studentResult_index', $data);
    }

    public function studentResult_create($id){
        $data['title'] = "Nuevo Resultado Estudiantil";
        $data['id'] = $id;

        try {            
            //$data['educationalObjetives'] = $this->educationalObjetiveService->findByFaculty($id);     
            $data['educationalObjetives'] = EducationalObjetive::where('IdEspecialidad', Session::get('faculty-code'))
											->where('deleted_at', null)->get();       
        } catch (\Exception $e) {
            redirect()->back()->with('warning','Ha ocurrido un error'); 
        }
        //dd($data['educationalObjetives']);
        return view('flujoCoordinador.studentResult_create', $data);
    }

    public function studentResult_store(StudentResultRequest $request, $id){
        try {
            $studentsResult = $this->studentsResultService->create($request->all());
        } catch(\Exception $e) {
            redirect()->back()->with('warning','Ha ocurrido un error'); 
        }
        return redirect()->route('studentResult_index.flujoCoordinador',$id)->with('success', "El resultado estudiantil se ha registrado exitosamente");
    }

}
