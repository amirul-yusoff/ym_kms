<?php

namespace App\Http\Controllers;
use App\Http\Models\Member;
use Illuminate\Support\Facades\Gate;

class loginHistoryController extends Controller
{
	public function __construct()
    {
    	
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if (! Gate::allows('login_history_view')) {
            return abort(401);
        }
        $title = 'Login History';
        $url = 'login-history';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
        ];
        $members = Member::active()->notDeleted()->orderBy('last_login', 'desc')->get();
    	return view('login.index', compact('title', 'breadcrumb', 'url', 'members'));
    }
}