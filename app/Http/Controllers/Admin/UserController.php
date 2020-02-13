<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;
        $items = User::where('ten', 'LIKE', '%'.$query.'%')
        ->orWhere('email', 'LIKE', '%'.$query.'%')
        ->orWhere('sdt', 'LIKE', '%'.$query.'%')
        ->paginate(10);
        return response()->json($items);
    }

    public function show($id)
    {
        $items = User::findOrFail($id);
        return response()->json($items);
    }

    public function count()
    {
        $count = User::get()->count();
        return response()->json($count);
    }

    public function countPerMonth()
    {
        $chartDatas = User::select([
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS date'),
            DB::raw('COUNT(id) AS count'),
         ])
         ->whereBetween('created_at', [Carbon::now()->subMonth(11), Carbon::now()])
         ->groupBy('date')
         ->orderBy('date', 'ASC')
         ->get()
         ->toArray();
        return response()->json($chartDatas);
    }
}
