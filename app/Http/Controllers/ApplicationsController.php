<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Event;
use App\Application;

use DB;

class ApplicationsController extends Controller
{

    public function __construct()
    {
        view()->share('__table', 'applications');
        $this->middleware('auth');
    }


    public function getIndex(Request $request)
    {
        return view('applications.index', []);
    }

    public function getAdd(Request $request)
    {
        return view('applications.add', [
            '__mode' => 'create',
        ]);
    }

    public function getUpdate(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        return view('applications.add', [
            'model' => $application,
            '__mode' => 'update',
        ]);
    }

    public function getShow(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        return view('applications.show', [
            'model' => $application        ]);
    }

    public function getGrid(Request $request)
    {
        $len = $request->length;
        $start = $request->start;
        
        $columns = [
            'applications.id',
            'applications.name',
            'applications.user_id',
            'applications.zone',
            'applications.forward_proxy_host',
            'applications.enabled_http',
            'applications.enabled_https',
            'applications.created_at',
            'applications.updated_at',
            '"actions"',
        ];

        $select = "SELECT " . implode(', ', $columns);
        $presql = " FROM applications";
        if($request->search['value']) { 
            $presql .= " WHERE applications.name LIKE '%".$request->search['value']."%' ";
        }
        
        $presql .= " ";
        if($request->has('order')) {
            $presql .= " ORDER BY {$columns[$request->get('order')[0]['column']]} {$request->get('order')[0]['dir']}";
        }

        $sql = $select.$presql." LIMIT ".$start.",".$len;


        $qcount = DB::select("SELECT COUNT(applications.id) c".$presql);
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
        $application = null;
        if($id) { 
            $application = Application::findOrFail($id); 
        } else { 
            $application = new Application;
        }
        

        $application->name = $request->name;
        $application->user_id = $request->user_id;
        $application->zone = $request->zone;
        $application->forward_proxy_host = $request->forward_proxy_host;
        $application->enabled_http = $request->enabled_http;
        $application->enabled_https = $request->enabled_https;
        $application->created_at = $request->created_at;
        $application->updated_at = $request->updated_at;
        //$application->user_id = ($request->user_id ?: $request->user()->id);
        $application->save();

        if($id) {
            Event::fire('application.update', array($application));
        } else { 
            Event::fire('application.create', array($application));
        }

        return redirect('/applications/index');

    }

    public function getDelete(Request $request, $id) {
        
        $application = Application::findOrFail($id);

        $application->delete();
        return redirect('/applications/index');
        
    }

    
}
