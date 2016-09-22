<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\RebuildCaddyfileEvent;
use App\Http\Controllers\Controller;
use DB;
use Event;
use Illuminate\Http\Request;

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
            'model' => $application]);
    }

    public function getGrid(Request $request)
    {
        $len = $request->length;
        $start = $request->start;

        $columns = [
            'applications.id',
            'applications.name',
            'users.name as user_name',
            'applications.zone',
            'applications.forward_proxy_host',
            // 'applications.enabled_http',
            // 'applications.enabled_https',
            'applications.created_at',
            'applications.updated_at',
            '"actions"',
        ];

        $select = "SELECT " . implode(', ', $columns);
        $presql = " FROM applications ";
        $presql .= " join users on users.id = applications.user_id";
        // $presql .= " where user_id = '{$request->user()->id}'";
        if ($request->search['value']) {
            $presql .= " WHERE applications.name LIKE '%" . $request->search['value'] . "%' ";
        }

        $presql .= " ";
        if ($request->has('order')) {
            $presql .= " ORDER BY {$columns[$request->get('order')[0]['column']]} {$request->get('order')[0]['dir']}";
        }

        $sql = $select . $presql . " LIMIT " . $start . "," . $len;

        $qcount = DB::select("SELECT COUNT(applications.id) c" . $presql);
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

    public function postSave(Request $request, $id = null)
    {
        //
        $this->validate($request, [
            'name' => 'required|max:255',
            'zone' => 'domain',
        ]);

        $application = null;
        if ($id) {
            $application = Application::findOrFail($id);
        } else {
            $application = new Application;
        }

        $application->name = $request->name;
        $application->zone = $request->zone;
        $application->forward_proxy_host = $request->forward_proxy_host;
        $application->enabled_https = $request->enabled_https;
        $application->user_id = ($request->user_id ?: $request->user()->id);
        $application->save();
        Event::fire(new RebuildCaddyfileEvent());
        return redirect('/applications/index');
    }

    public function getDelete(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        Event::fire(new RebuildCaddyfileEvent());
        return redirect('/applications/index');
    }

}
