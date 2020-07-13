<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Car;
use Auth;
use PdfReport;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function revenue(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if ($user->hasPermission('bao-cao')) {

            $chartDatas = array();
            $end = Carbon::today();
            $start = $end->copy()->subDays(6);
            if ($request->end != null) {
                $end = Carbon::createFromFormat('Y/m/d', $request->end);
            }
            if ($request->start != null) {
                $start = Carbon::createFromFormat('Y/m/d', $request->start);
            }

            $diff = $start->diff($end)->days;

            for ($i = $diff; $i >= 0; $i--) {
                $day = $end->copy()->subDays($i);
                $count = DB::table('cars')->select([
                    DB::raw('SUM(phi) AS count'),
                ])
                    ->whereDate('created_at', $day)
                    ->where('trangthai', '=', 2)
                    ->first();

                if ($count->count == null) {
                    $count->count = 0;
                }
                $obj = new \stdClass();
                $obj->date = $day->toDateString();
                $obj->count = $count->count;
                array_push($chartDatas, $obj);
            }

            $records = Car::where('trangthai', '=', 2)->whereBetween('created_at', [$start, $end])->orderBy('phi', 'DESC')->with([
                'users',
                'types.brands',
                'colors',
                'furnitures',
                'conditions',
                'fuels',
                'locations',
                'origins',
                'styles',
                'transmissions',
                'convenientcars.convenients',
            ])->limit(10)->get();

            $data = new \stdClass();
            $data->chartData = $chartDatas;
            $data->records = $records;

            return response()->json($data);
        }

        return response([
            'message' => 'Bạn không có quyền này!'
        ], 401);
    }

    public function revenueReport(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if ($user->hasPermission('bao-cao')) {

            $toDate = Carbon::today();
            $fromDate = $toDate->copy()->subDays(6);
            if ($request->end != null) {
                $toDate = Carbon::createFromFormat('Y/m/d', $request->end);
            }
            if ($request->start != null) {
                $fromDate = Carbon::createFromFormat('Y/m/d', $request->start);
            }

            $title = 'BÁO CÁO DOANH THU'; // Report title

            $meta = [ // For displaying filters description on header
                'Thời gian' => $fromDate->format('d/m/Y') . ' đến ' . $toDate->format('d/m/Y')
            ];

            $queryBuilder = Car::select(['ten', 'phi', 'created_at']) // Do some querying..
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->where('trangthai', '=', 2)
                ->orderBy('created_at');

            $columns = [ // Set Column to be displayed
                'Tiêu đề' => 'ten',
                'Phí' => 'phi',
                'Ngày tạo', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            ];

            // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
            return PdfReport::of($title, $meta, $queryBuilder, $columns)
                ->setPaper('a4')
                ->editColumn('Ngày tạo', [ // Change column class or manipulate its data for displaying to report
                    'displayAs' => function ($result) {
                        return $result->created_at->format('d/m/Y');
                    },
                    'class' => 'right'
                ])
                ->editColumn('Phí', [ // Mass edit column
                    'class' => 'right bold',
                    'displayAs' => function($result) {
                        return number_format($result->phi);
                    }
                ])
                ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                    'Phí' => 'VND' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                ])
                ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        }

        return response([
            'message' => 'Bạn không có quyền này!'
        ], 401);
    }
}
