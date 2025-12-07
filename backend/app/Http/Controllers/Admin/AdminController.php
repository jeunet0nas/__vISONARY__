<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminRequest;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        // Orders Statistics
        $todayOrders = Order::whereDate('created_at', Carbon::today())->get();
        $yesterdayOrders = Order::whereDate('created_at', Carbon::yesterday())->get();
        $monthOrders = Order::whereMonth('created_at', Carbon::now()->month)->get();
        $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->get();

        // Revenue Statistics
        $todayRevenue = $todayOrders->sum('grand_total');
        $yesterdayRevenue = $yesterdayOrders->sum('grand_total');
        $monthRevenue = $monthOrders->sum('grand_total');
        $yearRevenue = $yearOrders->sum('grand_total');

        // Revenue for last 7 days (for chart)
        $last7DaysRevenue = [];
        $last7DaysLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7DaysLabels[] = $date->format('d/m');
            $last7DaysRevenue[] = Order::whereDate('created_at', $date)
                ->sum('grand_total');
        }

        // Orders by status (for pie chart)
        $ordersByStatus = Order::select('payment_status', DB::raw('count(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status')
            ->toArray();

        // Users Statistics
        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', Carbon::today())->count();
        $yesterdayUsers = User::whereDate('created_at', Carbon::yesterday())->count();
        $usersWithOrders = User::has('orders')->count();
        $completedProfiles = User::where('profile_completed', 1)->count();

        return view('admin.dashboard')->with([
            // Orders data
            'todayOrders' => $todayOrders,
            'yesterdayOrders' => $yesterdayOrders,
            'monthOrders' => $monthOrders,
            'yearOrders' => $yearOrders,

            // Revenue data
            'todayRevenue' => $todayRevenue,
            'yesterdayRevenue' => $yesterdayRevenue,
            'monthRevenue' => $monthRevenue,
            'yearRevenue' => $yearRevenue,

            // Chart data
            'last7DaysLabels' => json_encode($last7DaysLabels),
            'last7DaysRevenue' => json_encode($last7DaysRevenue),
            'ordersByStatus' => json_encode($ordersByStatus),

            // Users data
            'totalUsers' => $totalUsers,
            'todayUsers' => $todayUsers,
            'yesterdayUsers' => $yesterdayUsers,
            'usersWithOrders' => $usersWithOrders,
            'completedProfiles' => $completedProfiles,
        ]);
    }

    public function login(){
        if(!auth()->guard('admin')->check()){
            return view('admin.login');
        }
        return redirect('admin/dashboard');
    }

    public function auth(AuthAdminRequest $req){
        if($req->validated()){
            if(auth()->guard('admin')->attempt([
                'email' => $req->email,
                'password' => $req->password,
            ])){
                $req->session()->regenerate();
                return redirect()->route('admin.index');
            } else{
                return redirect()->route('admin.login')->with([
                    'error' => 'Thông tin đăng nhập sai, hãy thử lại!'
                ]);
            }
        }
    }

    public function logout(){
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
