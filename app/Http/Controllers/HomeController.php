<?php

namespace App\Http\Controllers;
use App\DailyCashCoin;
use App\district_model;
use App\LockPermission;
use App\PanchayatList;
use App\PatwarList;
use App\VillageList;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\open_new_ac_model;
use App\member_type_model;
use Auth;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        // Auth::user()->roles->find(Auth::user()->id);
        $this->middleware('auth');
// User table
        if (Schema::hasTable('Users')) {
            Schema::table('Users', function (Blueprint $table) {
                if (!Schema::hasColumn('Users', 'entry_type')) 
                {
                    $table->integer('entry_type')->default(0);
                }    
            });
        }
// Open new account table
        if (Schema::hasTable('open_new_ac_models')) {
            Schema::table('open_new_ac_models', function (Blueprint $table) {
                if (!Schema::hasColumn('open_new_ac_models', 'patwar'))
                {
                    $table->string('patwar')->default(null)->nullable();
                }
                if (!Schema::hasColumn('open_new_ac_models', 'cast'))
                {
                    $table->string('cast')->default(null)->nullable();
                }
                if (!Schema::hasColumn('open_new_ac_models', 'updated_by'))
                {
                    $table->unsignedBigInteger('updated_by')->default(0)->nullable();
                }
                if (!Schema::hasColumn('open_new_ac_models', 'gaurdian_type'))
                {
                    $table->string('gaurdian_type')->default(null)->nullable();
                }
                if (!Schema::hasColumn('open_new_ac_models', 'member_name'))
                {
                    $table->string('member_name')->default(null)->nullable();
                }
                if (!Schema::hasColumn('open_new_ac_models', 'new_gaurdian_name'))
                {
                    $table->string('new_gaurdian_name')->default(null)->nullable();
                }
                if (!Schema::hasColumn('open_new_ac_models', 'care'))
                {
                    $table->string('care')->default(null)->nullable();
                }
            });
        }
// Company Address Model
        if (Schema::hasTable('company_address_models')) {
            Schema::table('company_address_models', function (Blueprint $table) {
                if (!Schema::hasColumn('company_address_models', 'gst_number'))
                {
                    $table->string('gst_number')->nullable();
                }
            });
        }
//  saving_ac_models
        if (Schema::hasTable('saving_ac_models')) {
            Schema::table('saving_ac_models', function (Blueprint $table) {
                if (!Schema::hasColumn('saving_ac_models', 'sub_group'))
                {
                    $table->string('sub_group')->nullable();
                }
            });
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['items'] = open_new_ac_model::with('member_type_model')->orderBy('account_no','asc')->get();
        return view('home')->with($data);
        
    }

    public function GetDistrictById(Request $request)
    {
        $data = district_model::select('id','state_model_id','name')->whereStateModelId($request->get('id'))->get();
        return response()->json($data);
    }
    public function GetPatwarById(Request $request)
    {
        $data = PatwarList::select('id','district_model_id','name')->whereDistrictModelId($request->get('id'))->get();
        return response()->json($data);
    }
    public function GetPanchayatById(Request $request)
    {
        $data = PanchayatList::select('id','patwar_list_id','name')->wherePatwarListId($request->get('id'))->get();
        return response()->json($data);
    }
    public function GetVillageById(Request $request)
    {
        $data = VillageList::select('id','panchayat_list_id','name')->wherePanchayatListId($request->get('id'))->get();
        return response()->json($data);
    }

    public function LockToday(Request $request)
    {
        $user = Auth::user()->id;
        $lock_date = Carbon::now()->format('Y-m-d');
        $saveData = new LockPermission();
        $saveData->user_id = $user;
        $saveData->lock_date = $lock_date;
        $saveData->save();
        return redirect()->back()->with('success', 'Current day have closed by you successfully done!');;
    }

    public function SearchDailyCashCoin(Request $request)
    {
        $date = Carbon::parse($request->search)->format('Y-m-d');

            $items_obj = [];
            $items_obj =  DailyCashCoin::where('date',$date)->first();
            $data['selectDate'] = $items_obj->date ?? $date;
            $data['searchDate'] = ClosingCashInHandByDate($items_obj->date ?? $date);

            $data['c1'] = $items_obj->two_thousand ?? 0;
            $data['v1'] = SetCoins($items_obj->two_thousand ?? 0, 2000);

            $data['c2'] = $items_obj->five_hundred ?? 0;
            $data['v2'] = SetCoins($items_obj->five_hundred ?? 0, 500);

            $data['c3'] = $items_obj->two_hundred ?? 0;
            $data['v3'] = SetCoins($items_obj->two_hundred ?? 0, 200);

            $data['c4'] = $items_obj->one_hundred ?? 0;
            $data['v4'] = SetCoins($items_obj->one_hundred ?? 0, 100);

            $data['c5'] = $items_obj->fifty ?? 0;
            $data['v5'] = SetCoins($items_obj->fifty ?? 0, 50);

            $data['c6'] = $items_obj->twenty ?? 0;
            $data['v6'] = SetCoins($items_obj->twenty ?? 0, 20);

            $data['c7'] = $items_obj->ten ?? 0;
            $data['v7'] = SetCoins($items_obj->ten ?? 0, 10);

            $data['c8'] = $items_obj->five ?? 0;
            $data['v8'] = SetCoins($items_obj->five ?? 0, 5);

            $data['c9'] = $items_obj->two ?? 0;
            $data['v9'] = SetCoins($items_obj->two ?? 0, 2);

            $data['c10'] = $items_obj->one ?? 0;
            $data['v10'] = SetCoins($items_obj->one ?? 0, 1);

            $data['c11'] = $items_obj->paisa ?? 0;
            $data['v11'] = SetCoins($items_obj->paisa ?? 0, .01);


        return response()->json(['data'=>$data, 'status'=>200]);

    }

    public function SearchDailyCashCoinUpdate(Request $request)
    {
//        return $request->all();
        if ($request->SelectedDate)
        {
            $date = $request->SelectedDate;
        }
        else{
            $date = Carbon::now()->format('Y-m-d');
        }

        $saveData = DailyCashCoin::where('date',$date)->first();
        if ($saveData)
        {
            $updateData = DailyCashCoin::where('date',$date)->first();
        }
        else{
            $updateData = new DailyCashCoin();
        }
        $updateData->two_thousand = $request->TwoThousand;
        $updateData->five_hundred = $request->FiveHundred;
        $updateData->two_hundred	 = $request->TwoHundred;
        $updateData->one_hundred = $request->OneHundred;
        $updateData->fifty = $request->Fifty;
        $updateData->twenty = $request->Twenty;
        $updateData->ten = $request->Ten;
        $updateData->five = $request->Five;
        $updateData->two = $request->Two;
        $updateData->one = $request->One;
        $updateData->paisa = $request->Paisa;
        $updateData->date = $date;
        $updateData->save();
        return response()->json(['data'=>'Data successfully updated!', 'status'=>200]);
    }
}
