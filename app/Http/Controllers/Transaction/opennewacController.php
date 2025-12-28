<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\session_master_model;
use App\branch_model;
use App\open_new_ac_model;
use App\member_type_model;
use App\ac_type_model;
use App\state_model;
use App\district_model;
use App\company_address_model;
use Auth;
use DB;
use Response;
use App\User;

class opennewacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth','restrictpi']);
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        
        $items_obj = open_new_ac_model::select(
            'id',
            'member_type_model_id',
            'account_no',
            'full_name',
            'father_name',
            'contact_no',
            'status',
            'contact_no',
            'village'
        )->with('member_type_model')
        ->orderBy('member_type_model_id','asc')
        ->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->search)
        {
            $items_obj->where('account_no','like','%'.$request->search.'%')->orWhere('contact_no','like','%'.$request->search.'%')->orWhere('full_name','like','%'.$request->search.'%')->orWhere('father_name','like','%'.$request->search.'%');
        }
        if(Auth::user()->staff_type == 'Agent')
        {
            $items_obj = $items_obj->where('agent_name',Auth::user()->id);
        }

        $data['items'] = $items_obj->paginate(100);
        // dd($data['items']);
        return view(TRANSACTION_OPEN_NEW_AC.'list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['branch'] = branch_model::orderBy('id','asc')->get();
        $data['membertypes'] = member_type_model::orderBy('id','asc')->get();
        $data['accountTypes'] = ac_type_model::orderBy('name','asc')->get();
        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['marital'] = ['Married','UnMarried','Widow','Other'];
        $data['occupations'] = ['Business','Private Job','Government','Farmer','Student','Other'];
        $data['religion'] = ['Hinduism','Muslim','Sikhism','Christians','Buddhism','Jainism'];
        $data['cast_category'] = ['General','OBC','SC','ST','Other'];
        $data['education'] = ['5th','8th','10th','12th','Graduate','Post Graduate','Other'];
        $data['language'] = ['Hindi','English','Urdu','Punjabi','Other'];
        $data['vehicles'] = ['Two Wheeler','Four Wheeler','Other'];
        $data['permissions'] = ['Share','Saving','DDS','DRD','RD','FD','Loan','MIS'];
        $data['agents'] = User::where('staff_type','Agent')->orderBy('name','asc')->get();

        return view(TRANSACTION_OPEN_NEW_AC."create")->with($data);
    }

     public function updatelocation(Request $request,$id = null, $dd = null)
    {
        // return $id;
        $id = $request->id;
        $data = district_model::select('id','state_model_id','name')->orderBy('name','asc')->where('state_model_id',$id)->get();
        return Response()->json([$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required',
            'member_type_model_id' => 'required|unique_with:open_new_ac_models,account_no',
            'type_of_account' => 'required',
            'gaurdian_name' => 'sometimes',
            'gaurdian_aadhar' => 'bail|nullable|numeric|digits:12',
            'gaurdian_pan' => 'bail|nullable|digits:10',
            'gaurdian_mobile' => 'bail|nullable|numeric|digits:10',
            'account_no' => 'bail|required',
            'ac_opening_date' => 'bail|required',
            'ac_opening_amount' => 'bail|required|numeric',
            'member_name' => 'required',
            
            'gender' => 'required',
            'agent_name' => 'required',
            'aadhar' => 'bail|required|numeric|digits:12',
            'mobile' => 'bail|required|numeric|digits:10',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
            'current_pin_code' => 'bail|nullable|numeric|digits:6',
            'ac_permissions' => 'required',
           
            'image' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg|max:4000',
            'signature' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg|max:4000',
            
        ], [
            // 'branch_name.required' => 'Branch Name is required',
        ]);

        if ($validator->passes()) {
            $item = new open_new_ac_model();
            
                $item->branch_model_id = $request->branch_name;
                $item->member_type_model_id = $request->member_type_model_id;
                $item->ac_type_model_id = $request->type_of_account;
                $item->gaurdian_name = $request->gaurdian_name;
                $item->gaurdian_aadhar = $request->gaurdian_aadhar;
                $item->gaurdian_pan = $request->gaurdian_pan;
                $item->gaurdian_mobile = $request->gaurdian_mobile;
                $item->account_no = $request->account_no;
                $item->ac_opening_date = $request->ac_opening_date;
                $item->ac_opening_amount = $request->ac_opening_amount;
                $item->full_name = $request->member_name;
                $item->father_name = $request->father_name;
                $item->mother_name = $request->mother_name;
                $item->gender = $request->gender;
                $item->marital = $request->marital_status;
                $item->husband_name = $request->husband_wife_name;
                $item->aadhar = $request->aadhar;
                $item->pan = $request->pan;
                $item->current_address_first = $request->current_address_line;
                $item->village = $request->current_village_or_city;
                $item->state_model_id = $request->current_state;
                $item->district_model_id = $request->current_district;
                $item->tehsil = $request->current_tehsil;
                $item->pin_code = $request->current_pin_code;
                $item->perm_address_first = $request->permanent_address_line;
                $item->perm_village = $request->permanent_village_or_city;
                $item->perm_state_model = $request->permanent_state;
                $item->perm_district_model = $request->permanent_district;
                $item->perm_tehsil = $request->permanent_tehsil;
                $item->perm_pin_code = $request->permanent_pin_code;
                $item->relegion = $request->religion;
                $item->category = $request->cast_category;
                $item->dob = $request->date_of_birth;
                $item->occupation = $request->occupation;
                $item->education = $request->education;
                $item->language = $request->language;
                $item->nationality = $request->nationality;
                $item->residence_type = $request->residence_type;
                if($request->vehicle):
                    $item->vehicle = implode(',', array_filter($request->vehicle));
                endif;
                $item->contact_no = $request->mobile;
                $item->email = $request->email;
                $item->open_ac_purpose = $request->opening_account_purpose;
                $item->annual_income = $request->annual_income;
                $item->passport = $request->passport;
                $item->passport_validity = $request->validity_of_passport;
                $item->nominee_name = $request->nominee_name;
                $item->nominee_address = $request->nominee_address;
                $item->nominee_relation = $request->nominee_relation;
                $item->nominee_dob = $request->nominee_dob;
                $item->agent_name = $request->agent_name;
                $item->ward = $request->ward;
                $item->lf_no = $request->lf_no;
                $item->ledger_no = $request->ledger;
                $item->page_no = $request->page;
                $item->status = $request->status;
                if($request->ac_permissions):
                    $item->ac_permission = implode(',', array_filter($request->ac_permissions));
                endif;
                $item->token = $request->_token;

                if($request->hasFile('image'))
            {
                $relPath = '/storage/member-photo/';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('image');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();
                 
                    $destinationPath = public_path('/storage/member-photo');
                    $image->move($destinationPath, $input['imagename']);
                    $item->file = $relPath.''.$input['imagename'];
            }

            if($request->hasFile('signature'))
            {
                $relPath = '/storage/member-signature/';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('signature');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();

                    $destinationPath = public_path('/storage/member-signature');
                    $image->move($destinationPath, $input['imagename']);
                    $item->signature = $relPath.''.$input['imagename'];
            }
            if($request->hasFile('document'))
            {
                $relPath = '/storage/member-document';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('document');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();
                 
                    $destinationPath = public_path('/storage/member-document');
                    $image->move($destinationPath, $input['imagename']);
                    $item->document = $input['imagename'];
            }

            $item->save();    
// SMS sending Code start
$mobile1 = $item->contact_no;                
$message = "Congratulation! Dear customer your new account with no. ". $item->account_no ." has been opened on ". date('d-M-Y', strtotime($item->created_at));
sendSms($mobile1, $message);

// Sms sending Code End           
            $return_url = url(TRANSACTION_URL_OPEN_NEW_AC);
                return response()->json(['success'=>'<li><span>Congratulation!</span> The New Account Opend Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
    }

        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['item'] = open_new_ac_model::with('ac_type_model','state_model')->find($id);
        $data['agent_name'] = User::where('id',$data['item']->agent_name)->first();
        $data['branch'] = branch_model::orderBy('id','asc')->get();
        $data['membertypes'] = member_type_model::orderBy('id','asc')->get();
        $data['accountTypes'] = ac_type_model::orderBy('name','asc')->get();
        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->state_model_id)->get();
        $data['perma_districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->perm_state_model)->get();
// permanent state & districts        
        $data['permanent_state'] = state_model::where('id',$data['item']->perm_state_model)->first();
        $data['permanent_dist'] = district_model::where('id',$data['item']->perm_district_model)->first();

        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['marital'] = ['Married','UnMarried','Widow','Other'];
       
        $data['occupations'] = ['Business','Private Job','Government','Farmer','Student','Other'];
        $data['category'] = ['General','OBC','SC','ST','Other'];
        $data['gender'] = ['Male','Female','Other'];
        $data['religion'] = ['Hinduism','Muslim','Sikhism','Christians','Buddhism','Jainism'];
        $data['cast_category'] = ['General','OBC','SC','ST','Other'];
        $data['education'] = ['5th','8th','10th','12th','Graduate','Post Graduate','Other'];
        $data['language'] = ['Hindi','English','Urdu','Punjabi','Other'];

        return view(TRANSACTION_OPEN_NEW_AC.'view')->with($data);
    }

    public function printProfile($id)
    {
        $data['item'] = open_new_ac_model::with('ac_type_model','state_model')->find($id);
        $data['agent_name'] = User::where('id',$data['item']->agent_name)->first();
        $data['branch'] = branch_model::orderBy('id','asc')->get();
        $data['membertypes'] = member_type_model::orderBy('id','asc')->get();
        $data['accountTypes'] = ac_type_model::orderBy('name','asc')->get();
        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->state_model_id)->get();
        $data['perma_districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->perm_state_model)->get();
// permanent state & districts        
        $data['permanent_state'] = state_model::where('id',$data['item']->perm_state_model)->first();
        $data['permanent_dist'] = district_model::where('id',$data['item']->perm_district_model)->first();
        $data['company_address'] = company_address_model::first();

        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['marital'] = ['Married','UnMarried','Widow','Other'];
       
        $data['occupations'] = ['Business','Private Job','Government','Farmer','Student','Other'];
        $data['category'] = ['General','OBC','SC','ST','Other'];
        $data['gender'] = ['Male','Female','Other'];
        $data['religion'] = ['Hinduism','Muslim','Sikhism','Christians','Buddhism','Jainism'];
        $data['cast_category'] = ['General','OBC','SC','ST','Other'];
        $data['education'] = ['5th','8th','10th','12th','Graduate','Post Graduate','Other'];
        $data['language'] = ['Hindi','English','Urdu','Punjabi','Other'];

        return view(TRANSACTION_OPEN_NEW_AC.'print-profile')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['item'] = open_new_ac_model::find($id);
        $data['branch'] = branch_model::orderBy('id','asc')->get();
        $data['membertypes'] = member_type_model::orderBy('id','asc')->get();
        $data['accountTypes'] = ac_type_model::orderBy('name','asc')->get();
        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->state_model_id)->get();
        $data['perma_districts'] = district_model::orderBy('name','asc')->where('state_model_id',$data['item']->perm_state_model)->get();
        $data['relations'] = ['Father','Mother','Husband','Wife','Son','Daughter','Nephew','Elder Brother','Younger Brother','Elder Sister','Younger Sister','Grand Father','Grand Mother','Uncle','Aunt','Son in LAW','Brother in Law','Sister in Law','Step Mother','Step Father','Step Sister','Step Brother','Step Son','Step Daughter'];
        $data['marital'] = ['Married','UnMarried','Widow','Other'];
        $data['occupations'] = ['Business','Private Job','Government','Farmer','Student','Other'];
        $data['category'] = ['General','OBC','SC','ST','Other'];
        $data['gender'] = ['Male','Female','Other'];
        $data['religion'] = ['Hinduism','Muslim','Sikhism','Christians','Buddhism','Jainism'];
        $data['cast_category'] = ['General','OBC','SC','ST','Other'];
        $data['education'] = ['5th','8th','10th','12th','Graduate','Post Graduate','Other'];
        $data['language'] = ['Hindi','English','Urdu','Punjabi','Other'];
        $data['vehicles'] = ['Two Wheeler','Four Wheeler','Other'];
        $data['match_vehicles'] = explode(',', $data['item']->vehicle);
        $data['permissions'] = ['Share','Saving','DDS','DRD','RD','FD','Loan','MIS'];
        $data['match_permissions'] = explode(',', $data['item']->ac_permission);
        $data['agents'] = User::where('staff_type','Agent')->orderBy('name','asc')->get();
        return view(TRANSACTION_OPEN_NEW_AC.'edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'ac_opening_date' => 'bail|required',
            'ac_opening_amount' => 'bail|required|numeric',
            'type_of_account' => 'required',
            'gaurdian_name' => 'sometimes',
            'gaurdian_aadhar' => 'bail|nullable|numeric|digits:12',
            // 'gaurdian_pan' => 'bail|nullable|digits:10',
            'gaurdian_mobile' => 'bail|nullable|numeric|digits:10',
            'member_name' => 'required',
            
            'gender' => 'required',
            'marital_status' => 'required',
            'agent_name' => 'required',
            'aadhar' => 'bail|required|numeric|digits:12',
            'mobile' => 'bail|required|numeric|digits:10',
            'nominee_name' => 'bail|required',
            'nominee_relation' => 'bail|required',
            'email' => 'bail|nullable|email',
            'current_pin_code' => 'bail|nullable|numeric|digits:6',
            'permanent_pin_code' => 'bail|nullable|numeric|digits:6',
            'ac_permissions' => 'required',
            'image' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg|max:4000',
            'signature' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg|max:4000',
            
        ], [
            // 'branch_name.required' => 'Branch Name is required',
        ]);

        if ($validator->passes()) {
            $item = open_new_ac_model::find($id);
                $item->ac_opening_date = $request->ac_opening_date;
                $item->ac_opening_amount = $request->ac_opening_amount;            
                $item->gaurdian_name = $request->gaurdian_name;
                $item->gaurdian_aadhar = $request->gaurdian_aadhar;
                $item->gaurdian_pan = $request->gaurdian_pan;
                $item->gaurdian_mobile = $request->gaurdian_mobile;
                $item->full_name = $request->member_name;
                $item->father_name = $request->father_name;
                $item->mother_name = $request->mother_name;
                $item->gender = $request->gender;
                $item->marital = $request->marital_status;
                $item->husband_name = $request->husband_wife_name;
                $item->aadhar = $request->aadhar;
                $item->pan = $request->pan;
                $item->current_address_first = $request->current_address_line;
                $item->village = $request->current_village_or_city;
                $item->state_model_id = $request->current_state;
                $item->district_model_id = $request->current_district;
                $item->tehsil = $request->current_tehsil;
                $item->pin_code = $request->current_pin_code;
                $item->perm_address_first = $request->permanent_address_line;
                $item->perm_village = $request->permanent_village_or_city;
                $item->perm_state_model = $request->permanent_state;
                $item->perm_district_model = $request->permanent_district;
                $item->perm_tehsil = $request->permanent_tehsil;
                $item->perm_pin_code = $request->permanent_pin_code;
                $item->relegion = $request->religion;
                $item->category = $request->cast_category;
                $item->dob = $request->date_of_birth;
                $item->occupation = $request->occupation;
                $item->education = $request->education;
                $item->language = $request->language;
                $item->nationality = $request->nationality;
                $item->residence_type = $request->residence_type;
                if($request->vehicle):
                    $item->vehicle = implode(',', array_filter($request->vehicle));
                endif;
                $item->contact_no = $request->mobile;
                $item->email = $request->email;
                $item->open_ac_purpose = $request->opening_account_purpose;
                $item->annual_income = $request->annual_income;
                $item->passport = $request->passport;
                $item->passport_validity = $request->validity_of_passport;
                $item->nominee_name = $request->nominee_name;
                $item->nominee_address = $request->nominee_address;
                $item->nominee_relation = $request->nominee_relation;
                $item->nominee_dob = $request->nominee_dob;
                $item->agent_name = $request->agent_name;
                $item->ward = $request->ward;
                $item->lf_no = $request->lf_no;
                $item->ledger_no = $request->ledger;
                $item->page_no = $request->page;
                $item->status = $request->status;
                if($request->ac_permissions):
                    $item->ac_permission = implode(',', array_filter($request->ac_permissions));
                endif;
                $item->updated_by = Auth::user()->id;

                $item->token = $request->_token;

                if($request->hasFile('image'))
            {
                $relPath = '/storage/member-photo/';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('image');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();
                 
                    $destinationPath = public_path('/storage/member-photo');
                    $image->move($destinationPath, $input['imagename']);
                    $item->file = $relPath.''.$input['imagename'];
            }

            if($request->hasFile('signature'))
            {
                $relPath = '/storage/member-signature/';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('signature');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();

                    $destinationPath = public_path('/storage/member-signature');
                    $image->move($destinationPath, $input['imagename']);
                    $item->signature = $relPath.''.$input['imagename'];
            }

            if($request->hasFile('document'))
            {
                $relPath = '/storage/member-document';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('document');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();
                 
                    $destinationPath = public_path('/storage/member-document');
                    $image->move($destinationPath, $input['imagename']);
                    $item->document = $input['imagename'];
            }

                $item->save();    
           
            $return_url = url(TRANSACTION_URL_OPEN_NEW_AC);
                return response()->json(['success'=>'<li><span>Congratulation!</span> Account Successfully Updated.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
    }

        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
         //Auth::login($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $item = open_new_ac_model::find($id);
    //     if($item->delete())
    //     {
    //        return response()->json(['success'=>'done']);
    //     } 
    //     else
    //     {
    //        return response()->json(['error'=>'Failed']); 
    //     }
    // }

    public function OpenShortAccount()
    {
        return view('Transaction.Open_New_Ac.create-short-account');
    }
    public function OpenShortAccountSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required',
            'member_type_model_id' => 'required|unique_with:open_new_ac_models,account_no',
            'account_no' => 'bail|required',
            'ac_opening_date' => 'bail|required',
            'type_of_account' => 'required',

            'member_gaurdian_name' => 'sometimes',
            'gaurdian_aadhar' => 'bail|nullable|numeric|digits:12',
            'gaurdian_pan' => 'bail|nullable|digits:10',
            'gaurdian_mobile' => 'bail|nullable|numeric|digits:10',
            'member_name' => 'required',
            'GuardianType' => 'required',
            'fatherName' => 'sometimes',
            'husbandName' => 'sometimes',
            'guardianName' => 'sometimes',

            'gender' => 'required',
//            'agent_name' => 'required',
            'aadhar' => 'bail|required|numeric|digits:12',
            'mobile' => 'bail|required|numeric|digits:10',
            'current_state' => 'bail|required',
            'current_district' => 'bail|required',
            'patwar' => 'required',
            'panchayat' => 'required',
            'current_tehsil' => 'required',
            'village' => 'required',
            'address' => 'required',
            'pinCode' => 'required|numeric|digits:6',
            'religion' => 'required',
            'category' => 'required',
            'cast' => 'required',
            'date_of_birth' => 'required',
            'ac_permissions' => 'required',

            'image' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg|max:4000',
            'signature' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg|max:4000',

        ], [
            // 'branch_name.required' => 'Branch Name is required',
        ]);

        if ($validator->passes()) {
            $item = new open_new_ac_model();

            $item->branch_model_id = $request->branch_name;
            $item->member_type_model_id = $request->member_type_model_id;
            $item->account_no = $request->account_no;
            $item->ac_opening_date = $request->ac_opening_date;
            $item->ac_type_model_id = $request->type_of_account;

            $item->gaurdian_name = $request->member_gaurdian_name;
            $item->gaurdian_aadhar = $request->gaurdian_aadhar;
            $item->gaurdian_pan = $request->gaurdian_pan;
            $item->gaurdian_mobile = $request->gaurdian_mobile;

            $item->gaurdian_type = $request->GuardianType;
            $item->full_name = $request->member_name;
            $item->husband_name = $request->husbandName;
            $item->father_name = $request->fatherName;
            $item->new_gaurdian_name = $request->guardianName;
            $item->gender = $request->gender;
            $item->aadhar = $request->aadhar;
            $item->pan = $request->pan;
            $item->contact_no = $request->mobile;
            $item->state_model_id = $request->current_state;
            $item->district_model_id = $request->current_district;
            $item->patwar = $request->patwar;
            $item->panchayat = $request->panchayat;
            $item->tehsil = $request->current_tehsil;
            $item->village = $request->village;
            $item->perm_address_first = $request->address;
            $item->pin_code = $request->pinCode;
            $item->relegion = $request->religion;
            $item->category = $request->category;
            $item->cast = $request->cast;
            $item->dob = $request->date_of_birth;
            $item->nominee_name = $request->nominee_name;
            $item->nominee_relation = $request->nominee_relation;
            $item->ward = $request->ward;
            $item->lf_no = $request->lfNumber;
            $item->ledger_no = $request->ledgerNumber;
            $item->page_no = $request->pageNumber;

            $item->status = $request->status;
            if($request->ac_permissions):
                $item->ac_permission = implode(',', array_filter($request->ac_permissions));
            endif;
            $item->token = $request->_token;

            if($request->hasFile('image'))
            {
                $relPath = '/storage/member-photo/';
                if (!file_exists(public_path($relPath))) {
                    mkdir(public_path($relPath), 777, true);
                }
                $image = $request->file('image');
                $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/storage/member-photo');
                $image->move($destinationPath, $input['imagename']);
                $item->file = $relPath.''.$input['imagename'];
            }

            if($request->hasFile('signature'))
            {
                $relPath = '/storage/member-signature/';
                if (!file_exists(public_path($relPath))) {
                    mkdir(public_path($relPath), 777, true);
                }
                $image = $request->file('signature');
                $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/storage/member-signature');
                $image->move($destinationPath, $input['imagename']);
                $item->signature = $relPath.''.$input['imagename'];
            }
            if($request->hasFile('document'))
            {
                $relPath = '/storage/member-document';
                if (!file_exists(public_path($relPath))) {
                    mkdir(public_path($relPath), 777, true);
                }
                $image = $request->file('document');
                $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/storage/member-document');
                $image->move($destinationPath, $input['imagename']);
                $item->document = $input['imagename'];
            }

            $item->save();
// SMS sending Code start
            $mobile1 = $item->contact_no;
            $message = "Congratulation! Dear customer your new account with no. ". $item->account_no ." has been opened on ". date('d-M-Y', strtotime($item->created_at));
            sendSms($mobile1, $message);

// Sms sending Code End
            $return_url = route('transaction.open.short.account');
            return response()->json(['success'=>'<li><span>Congratulation!</span> The New Account Opend Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
        }

        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
        //Auth::login($user);
    }

    public function SearchAccount(Request $request)
    {
        $items_obj = [];
        $items_obj = open_new_ac_model::select(
            'account_no',
            'full_name',
            'father_name',
            'contact_no',
            'status',
            'village'
        )->orderBy('member_type_model_id','asc')->orderBy(DB::raw('CAST(account_no AS UNSIGNED), account_no'));
        if($request->search)
        {
          $items_obj =  $items_obj->where('account_no','like','%'.$request->search.'%')->orWhere('contact_no','like','%'.$request->search.'%')->orWhere('full_name','like','%'.$request->search.'%')->orWhere('father_name','like','%'.$request->search.'%')->orWhere('village','like','%'.$request->search.'%')->get();
        }
        return response()->json(['data'=>$items_obj, 'status'=>200]);

    }

    public function CreateShortAccount()
    {
        return view('Transaction.Open_New_Ac.create-short-account-new');
    }
    public function CreateShortAccountSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_name' => 'required',
            'member_type_model_id' => 'required|unique_with:open_new_ac_models,account_no',
            'account_no' => 'bail|required',
            'ac_opening_date' => 'bail|required',
            'type_of_account' => 'required',

            'member_gaurdian_name' => 'sometimes',
            'gaurdian_aadhar' => 'bail|nullable|numeric|digits:12',
            'gaurdian_pan' => 'bail|nullable|digits:10',
            'gaurdian_mobile' => 'bail|nullable|numeric|digits:10',
            'member_name' => 'required',
            'GuardianType' => 'required',
            'fatherName' => 'sometimes',
            'husbandName' => 'sometimes',
            'guardianName' => 'sometimes',

            'gender' => 'required',

            'aadhar' => 'bail|required|numeric|digits:12',
            'mobile' => 'bail|required|numeric|digits:10',
            'current_state' => 'bail|required',
            'current_district' => 'bail|required',

        ], [
            // 'branch_name.required' => 'Branch Name is required',
        ]);

        if ($validator->passes()) {
            $item = new open_new_ac_model();

            $item->branch_model_id = $request->branch_name;
            $item->member_type_model_id = $request->member_type_model_id;
            $item->account_no = $request->account_no;
            $item->ac_opening_date = $request->ac_opening_date;
            $item->ac_type_model_id = $request->type_of_account;

            $item->gaurdian_name = $request->member_gaurdian_name;
            $item->gaurdian_aadhar = $request->gaurdian_aadhar;
            $item->gaurdian_pan = $request->gaurdian_pan;
            $item->gaurdian_mobile = $request->gaurdian_mobile;

            $item->gaurdian_type = $request->GuardianType;
            $item->full_name = $request->member_name;
            $item->husband_name = $request->husbandName;
            $item->father_name = $request->fatherName;
            $item->new_gaurdian_name = $request->guardianName;
            $item->gender = $request->gender;
            $item->aadhar = $request->aadhar;
            $item->pan = $request->pan;
            $item->contact_no = $request->mobile;
            $item->state_model_id = $request->current_state;
            $item->district_model_id = $request->current_district;

            $item->status = $request->status;
            if($request->ac_permissions):
                $item->ac_permission = implode(',', array_filter($request->ac_permissions));
            endif;
            $item->token = $request->_token;


            $item->save();
// SMS sending Code start
            $mobile1 = $item->contact_no;
            $message = "Congratulation! Dear customer your new account with no. ". $item->account_no ." has been opened on ". date('d-M-Y', strtotime($item->created_at));
            sendSms($mobile1, $message);

// Sms sending Code End
            $return_url = route('transaction.create.short.account');
            return response()->json(['success'=>'<li><span>Congratulation!</span> The New Account Opend Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
        }

        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
        //Auth::login($user);
    }

    public function agentPermission()
    {
        $agents = User::where('staff_type', 'Agent')->orderBy('name', 'asc')->get();
        return view('Transaction.Open_New_Ac.agent-permission', compact('agents'));
    }


    public function fetchAccounts(Request $request)
    {
        $query = open_new_ac_model::query();

        // Exclude accounts assigned to other agents
        if ($request->agent_id) {
            $assignedAccountIds = DB::table('user_open_new_ac_model')
                ->where('user_id', '!=', $request->agent_id)
                ->pluck('open_new_ac_model_id')
                ->toArray();

            $query->whereNotIn('id', $assignedAccountIds);
        }

        // Apply search filter
        if ($request->term) {
            $query->where('account_no', 'like', '%' . $request->term . '%');
        }

        $accounts = $query->get();

        return response()->json(['data' => $accounts]);
    }



    public function saveAgentAssignments(Request $request)
    {
        
        $request->validate([
            'agent_id' => 'required|exists:users,id',
            'account_id' => 'required|exists:open_new_ac_models,id',
        ]);
    
        // Find the user and attach the account
        $user = User::findOrFail($request->agent_id);
    
        // Attach the account to the user using the pivot table
        $user->openNewAcModels()->attach($request->account_id);
    
        return response()->json(['success' => true, 'message' => 'Assignment saved successfully.']);
    }

    public function fetchAssignedAccounts(Request $request)
{
    $assignedAccounts = DB::table('user_open_new_ac_model')
        ->join('open_new_ac_models', 'user_open_new_ac_model.open_new_ac_model_id', '=', 'open_new_ac_models.id')
        ->where('user_open_new_ac_model.user_id', $request->agent_id)
        ->select(
            'open_new_ac_models.id',
            'open_new_ac_models.account_no',
            'open_new_ac_models.full_name', // Assuming this is the column for account holder name
            'open_new_ac_models.father_name',
            'open_new_ac_models.pin_code',
        )
        ->get();

    return response()->json(['data' => $assignedAccounts]);
}



}
