<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('manager user')) {
            return back()->with([
                'danger' => 'Permission Denied'
            ]);
        }
        $query = User::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $users = $query->paginate(15);

        return view('auth.index', [
            'users' => $users,
        ]);
    }

}
