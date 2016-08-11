<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Event;
use App\[[model_uc]];

use DB;

class [[controller_name]]Controller extends Controller
{

    public function __construct()
    {
        view()->share('__table', '[[tablename]]');
        $this->middleware('auth');
    }


    public function getIndex(Request $request)
    {
        return view('[[view_folder]].index', []);
    }

    public function getAdd(Request $request)
    {
        return view('[[view_folder]].add', [
            '__mode' => 'create',
        ]);
    }

    public function getUpdate(Request $request, $id)
    {
        $[[model_singular]] = [[model_uc]]::findOrFail($id);
        return view('[[view_folder]].add', [
            'model' => $[[model_singular]],
            '__mode' => 'update',
        ]);
    }

    public function getShow(Request $request, $id)
    {
        $[[model_singular]] = [[model_uc]]::findOrFail($id);
        return view('[[view_folder]].show', [
            'model' => $[[model_singular]]
        ]);
    }

    public function getGrid(Request $request)
    {
        $len = $request->length;
        $start = $request->start;
        
        $columns = [
[[foreach:columns]]
            '[[prefix]][[tablename]].[[i.name]]',
[[endforeach]]
            '"actions"',
        ];

        $select = "SELECT " . implode(', ', $columns);
        $presql = " FROM [[prefix]][[tablename]]";
        if($request->search['value']) { 
            $presql .= " WHERE [[prefix]][[tablename]].[[first_column_nonid]] LIKE '%".$request->search['value']."%' ";
        }
        
        $presql .= " ";
        if($request->has('order')) {
            $presql .= " ORDER BY {$columns[$request->get('order')[0]['column']]} {$request->get('order')[0]['dir']}";
        }

        $sql = $select.$presql." LIMIT ".$start.",".$len;


        $qcount = DB::select("SELECT COUNT([[prefix]][[tablename]].id) c".$presql);
        //print_r($qcount);
        $count = $qcount[0]->c;

        $results = DB::select($sql);
        $ret = [];
        foreach ($results as $row) {
            $r = [];
            foreach ($row as $value) {
                $r[] = $value;
            }
            $ret[] = $r;
        }

        $ret['data'] = $ret;
        $ret['recordsTotal'] = $count;
        $ret['iTotalDisplayRecords'] = $count;

        $ret['recordsFiltered'] = count($ret);
        $ret['draw'] = $_GET['draw'];

        return json_encode($ret);

    }


    public function postSave(Request $request, $id = null) {
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/
        $[[model_singular]] = null;
        if($id) { 
            $[[model_singular]] = [[model_uc]]::findOrFail($id); 
        } else { 
            $[[model_singular]] = new [[model_uc]];
        }
        

[[foreach:columns]][[if:i.name!='id']]
        $[[model_singular]]->[[i.name]] = $request->[[i.name]];
[[endif]][[endforeach]]
        //$[[model_singular]]->user_id = ($request->user_id ?: $request->user()->id);
        $[[model_singular]]->save();

        if($id) {
            Event::fire('[[model_singular]].update', array($[[model_singular]]));
        } else { 
            Event::fire('[[model_singular]].create', array($[[model_singular]]));
        }

        return redirect('/[[route_path]]/index');

    }

    public function getDelete(Request $request, $id) {
        
        $[[model_singular]] = [[model_uc]]::findOrFail($id);

        $[[model_singular]]->delete();
        return redirect('/[[route_path]]/index');
        
    }

    
}
