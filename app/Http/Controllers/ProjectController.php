<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['project']]);
    }

    public function project()
    {
        return view('admin/project');
    }

    public function getProjects(){
        $data = Project::join('tb_m_client', 'tb_m_client.client_id', '=', 'tb_m_project.client_id');
        $project_name = request('project_name');
        $client_id = request('client_id');
        $project_status = request('project_status');

        if($project_name != '' || $project_name != null ){
            $data->where('project_name', 'like', '%'. $project_name .'%');
        }
        if($client_id != '' || $client_id != null ){
            $data->where('tb_m_project.client_id', request('client_id'));
        }
        if($project_status != '' || $project_status != null ){
            $data->where('project_status', request('project_status'));
        }
        $data = $data->get();

        // return view('admin/project');
        return response()->json([
            'message' => 'Data berhasil di load!',
            'data' => $data
        ]);
    }


    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'project_name' => 'required',
            'client_id' => 'required|exists:tb_m_client,client_id',
            'project_start' => 'required',
            'project_end' => 'required',
            'project_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = Project::create([
            'project_name' => request('project_name'),
            'client_id' => request('client_id'),
            'project_start' => request('project_start'),
            'project_end' => request('project_end'),
            'project_status' => request('project_status'),
        ]);
        if($data){
              return response()->json([
                'message' => 'Projek berhasil ditambahkan!',
                'data' => $data
            ]);
        }else{
              return response()->json(['message' => 'Projek gagal ditambahkan!']);
        }
    }

    public function update(Request $request, Project $project)
    {
        // dd($request->all());
        $validator = Validator::make(request()->all(),[
            'project_name' => 'required',
            'client_id' => 'required|exists:tb_m_client,client_id',
            'project_start' => 'required',
            'project_end' => 'required',
            'project_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = $project::where('project_id', $request->project_id)->update([
            'project_name' => request('project_name'),
            'client_id' => request('client_id'),
            'project_start' => request('project_start'),
            'project_end' => request('project_end'),
            'project_status' => request('project_status'),
        ]);

        return response()->json([
            'message' => 'Projek berhasil diubah!',
            'data' => $data
        ]);
    }

    public function destroy(Project $project)
    {
        $ids = explode(' ', request()->project_id);
        foreach($ids as $id){
            $project::where('project_id', $id)->delete();
        }
        return response()->json(['message' => 'Data projek berhasil dihapus!']);
    }
}
