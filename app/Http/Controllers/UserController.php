<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Store;
use App\Models\Sale;

use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::searchUsers($request->search)
        ->with('store')
        ->select('id', 'stores_id', 'name')
        ->get();

        $this->addStorePayAttribute($users);

        return Inertia::render('UserList', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    public function userpaystore(Request $request)
    {
        $data = $request->all();
        $sale = new Sale;
        $sale->fill($data);
        $sale->save();
    }

    public function userpayupdate(Request $request)
    {
        $sale = Sale::find($request->id); 
        // return $request; 
        $sale->update([  
            "users_id" => $request->users_id,  
            "stores_id" => $request->stores_id,  
            "customer_payment" => $request->customer_payment,  
            "created_date" => $request->created_date,  
            "deleted_at" => '0',
        ]);  
    
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $UserDetail = User::find($user->id);
        $Stores = Store::all();

        // created_atの日付を 'Y-m-d' フォーマットに変換
        if ($UserDetail->sale) {
            foreach ($UserDetail->sale as $sale) {
                $sale->formatted_created_at = Carbon::parse($sale->created_at)->format('Y-m-d');
            }
        }

        return Inertia::render('Users/Index', ['User' => $UserDetail, 'Stores' => $Stores]);
    }

    public function getUser ($id)
    {
        $UserDetail = User::with(['sale' => function ($query) {
            $query->where(DB::raw("DATE_FORMAT(created_date, '%Y-%m')"), '=', now()->format('Y-m'))
                  ->orderBy('created_date', 'desc');
        }, 'sale.store'])
        ->find($id);

        return $UserDetail;
    }

    public function getUserSale (Request $request, $id)
    {
        $sale = Sale::find($id);
        return $sale;
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * 各ユーザーに店舗別売上属性を追加する
     */


     private function addStorePayAttribute($users)
     {
         // 現在の年月を取得
         $currentMonth = now()->format('Y-m');
     
         $stores = Store::select('id', 'store_name')->get();
         $storesIds = $stores->pluck('id', 'store_name')->toArray();
     
         $users->each(function ($user) use ($storesIds, $currentMonth) {
             $totalPayments = Sale::where('users_id', $user->id)
                 ->whereIn('stores_id', $storesIds)
                 ->where(DB::raw("DATE_FORMAT(created_date, '%Y-%m')"), '=', $currentMonth)
                 ->select('users_id', 'stores_id', DB::raw('SUM(customer_payment) as total_payment'))
                 ->groupBy('users_id', 'stores_id')
                 ->get();
     
             $storePay = $totalPayments
                 ->keyBy('stores_id')
                 ->map->total_payment
                 ->toArray();
     
             ksort($storePay);
     
             $user->setAttribute('store_pay', $storePay);
         });
     
         $storeNameMapping = $stores->pluck('store_name', 'id')->toArray();
     
         $users->transform(function ($user) use ($storeNameMapping) {
             if (isset($user->stores_id) && isset($storeNameMapping[$user->stores_id])) {
                 $newStorePay = array_map(function ($storeId, $value) use ($storeNameMapping) {
                     $storeName = $storeNameMapping[$storeId];
                     return [$storeName => $value];
                 }, array_keys($user->store_pay), $user->store_pay);
     
                 $user->store_pay = call_user_func_array('array_merge', $newStorePay);
             }
             
             return $user;
         });
     }
}