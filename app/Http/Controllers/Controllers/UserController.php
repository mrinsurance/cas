<?php

namespace App\Http\Controllers\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\User;
use Spatie\Permission\Models\Role;
use App\state_model;
use App\district_model;
use App\designation_model;
use App\branch_model;
use App\bank_model;
use DB;
use Hash;
use Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['items'] = User::orderBy('id','DESC')->get();
        return view('users.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['roles'] = Role::pluck('name','name')->all();
        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['designation'] = designation_model::orderBy('name','asc')->get();
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['bank'] = bank_model::orderBy('name','asc')->get();
        $data['staff_type'] = ["Staff","Agent","Saleman"];
        $data['qualification'] = ["12th","Graduate","Post Graduate"];
        // dd($data['roles']);
        return view('users.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'employee_code' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'date_of_birth' => 'required',
            'aadhar_number' => 'required|numeric|digits:12',
            'mobile' => 'required|numeric|digits:10',
            'photo' => 'bail|required|file|mimes:jpeg,png,jpg|max:4000',
            'mailing_address' => 'required',
            'mailing_country' => 'required',
            'mailing_state' => 'required',
            'mailing_district' => 'required',
            'mailing_city' => 'required',
            'mailing_pin' => 'required|numeric|digits:6',
            'staff_type' => 'required',
            'designation' => 'required',
            'branch' => 'required',
            'permanent_pin' => 'nullable|numeric|digits:6',
            'pay_scale' => 'nullable|numeric',
            'pay_band' => 'nullable|numeric',
            'grade_pay' => 'nullable|numeric',
            'current_basic' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'misc_advance' => 'nullable|numeric',
            'misc_deduction' => 'nullable|numeric',
            'bank_number' => 'nullable|numeric',
        ]);

        if ($validator->passes()) 
        {
            $password = Hash::make($request->password);
            
            $item = new User();
            $item->employee_code = $request->employee_code;
            $item->name = $request->name;
            $item->father_name = $request->father_name;
            $item->mother_name = $request->mother_name;
            $item->nominee_name = $request->nominee_name;
            $item->spouse_name = $request->spouse_name;
            $item->date_of_birth = $request->date_of_birth;
            $item->aadhar_number = $request->aadhar_number;
            $item->pan_number = $request->pan_number;
            $item->mobile = $request->mobile;
            $item->email = $request->email;
            $item->password = $password;
            $item->qualification = $request->qualification;
            $item->mailing_address = $request->mailing_address;
            $item->mailing_country = $request->mailing_country;
            $item->state_model_id = $request->mailing_state;
            $item->district_model_id = $request->mailing_district;
            $item->mailing_city = $request->mailing_city;
            $item->mailing_pin = $request->mailing_pin;
            $item->permanent_address = $request->permanent_address;
            $item->permanent_country = $request->permanent_country;
            $item->permanent_state = $request->permanent_state;
            $item->permanent_district = $request->permanent_district;
            $item->permanent_city = $request->permanent_city;
            $item->permanent_pin = $request->permanent_pin;
            $item->staff_type = $request->staff_type;
            $item->designation_model_id = $request->designation;
            $item->branch_model_id = $request->branch;
            $item->pay_scale = $request->pay_scale;
            $item->pay_band = $request->pay_band;
            $item->grade_pay = $request->grade_pay;
            $item->current_basic = $request->current_basic;
            $item->other_allowance = $request->other_allowance;
            $item->misc_advance = $request->misc_advance;
            $item->misc_deduction = $request->misc_deduction;
            $item->misc_deduction_date = $request->misc_deduction_date;
            $item->bank_model_id = $request->bank_name;
            $item->bank_number = $request->bank_number;
            $item->pf_number = $request->pf_number;
            $item->pf_applicable = $request->pf_applicable;
            if($request->hasFile('photo'))
            {
                $relPath = '/storage/user-photo';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('photo');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();

                    $destinationPath = public_path('/storage/user-photo');
                    $image->move($destinationPath, $input['imagename']);
                    $item->file = $relPath.'/'.$input['imagename'];
            }
            $item->save();
            $item->assignRole($request->input('roles'));

            $return_url = url(USERS);
            return response()->json(['success'=>'<li><span>Success!</span> The New User Created Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::find($id);
        return view('users.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::find($id);
        $data['roles'] = Role::pluck('name','name')->all();
        $data['userRole'] = $data['user']->roles->pluck('name','name')->all();

        $data['state'] = state_model::orderBy('name','asc')->get();
        $data['district'] = district_model::orderBy('name','asc')->where('state_model_id',$data['user']->state_model_id)->get();
        $data['designation'] = designation_model::orderBy('name','asc')->get();
        $data['branch'] = branch_model::orderBy('name','asc')->get();
        $data['bank'] = bank_model::orderBy('name','asc')->get();
        $data['staff_type'] = ["Staff","Agent","Saleman"];
        $data['qualification'] = ["12th","Graduate","Post Graduate"];
        return view('users.edit')->with($data);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'employee_code' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'date_of_birth' => 'required',
            'aadhar_number' => 'required|numeric|digits:12',
            'mobile' => 'required|numeric|digits:10',
            'photo' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4000',
            'mailing_address' => 'required',
            'mailing_country' => 'required',
            'mailing_state' => 'required',
            'mailing_district' => 'required',
            'mailing_city' => 'required',
            'mailing_pin' => 'required|numeric|digits:6',
            'staff_type' => 'required',
            'designation' => 'required',
            'branch' => 'required',
            'permanent_pin' => 'nullable|numeric|digits:6',
            'pay_scale' => 'nullable|numeric',
            'pay_band' => 'nullable|numeric',
            'grade_pay' => 'nullable|numeric',
            'current_basic' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'misc_advance' => 'nullable|numeric',
            'misc_deduction' => 'nullable|numeric',
            'bank_number' => 'nullable|numeric',
        ]);

        if ($validator->passes()) 
        {
            
            $item = User::find($id);
            $item->employee_code = $request->employee_code;
            $item->name = $request->name;
            $item->father_name = $request->father_name;
            $item->mother_name = $request->mother_name;
            $item->nominee_name = $request->nominee_name;
            $item->spouse_name = $request->spouse_name;
            $item->date_of_birth = $request->date_of_birth;
            $item->aadhar_number = $request->aadhar_number;
            $item->pan_number = $request->pan_number;
            $item->mobile = $request->mobile;
            $item->email = $request->email;
            if(!empty($request->password)){ 
                $item->password = Hash::make($request->password);
            }
            $item->qualification = $request->qualification;
            $item->mailing_address = $request->mailing_address;
            $item->mailing_country = $request->mailing_country;
            $item->state_model_id = $request->mailing_state;
            $item->district_model_id = $request->mailing_district;
            $item->mailing_city = $request->mailing_city;
            $item->mailing_pin = $request->mailing_pin;
            $item->permanent_address = $request->permanent_address;
            $item->permanent_country = $request->permanent_country;
            $item->permanent_state = $request->permanent_state;
            $item->permanent_district = $request->permanent_district;
            $item->permanent_city = $request->permanent_city;
            $item->permanent_pin = $request->permanent_pin;
            $item->staff_type = $request->staff_type;
            $item->designation_model_id = $request->designation;
            $item->branch_model_id = $request->branch;
            $item->pay_scale = $request->pay_scale;
            $item->pay_band = $request->pay_band;
            $item->grade_pay = $request->grade_pay;
            $item->current_basic = $request->current_basic;
            $item->other_allowance = $request->other_allowance;
            $item->misc_advance = $request->misc_advance;
            $item->misc_deduction = $request->misc_deduction;
            $item->misc_deduction_date = $request->misc_deduction_date;
            $item->bank_model_id = $request->bank_name;
            $item->bank_number = $request->bank_number;
            $item->pf_number = $request->pf_number;
            $item->pf_applicable = $request->pf_applicable;
            if($request->hasFile('photo'))
            {
                $relPath = '/storage/user-photo';
                    if (!file_exists(public_path($relPath))) {
                        mkdir(public_path($relPath), 777, true);
                    }
                    $image = $request->file('photo');
                    $input['imagename'] = date('Ymd').'-'.time().'.'.$image->getClientOriginalExtension();
                 
                    $destinationPath = public_path('/storage/user-photo');
                    $image->move($destinationPath, $input['imagename']);
                    $item->file = $relPath.'/'.$input['imagename'];
            }
            $item->save();
            DB::table('model_has_roles')->whereIn('model_id',[$id])->delete();
            $item->assignRole($request->input('roles'));

            $return_url = url(USERS);
            return response()->json(['success'=>'<li><span>Success!</span> User Updated Successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    public function editpassword($id)
    {
        $data['user'] = User::find($id);
        return view('users.edit-password')->with($data);
    }

    public function updatepassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|same:confirm-password',
        ]);

        if ($validator->passes()) 
        {
            $user = User::find($id);
            $user->password = Hash::make($request->password);
            $user->save();
           
            $return_url = url(USERS);
                return response()->json(['success'=>'<li><span>Success!</span> Password updated successfully.</li>','return_url'=>$return_url,'sec_key'=>$request->all()]);
        }
        return response()->json(['error'=>$validator->errors(),'sec_key'=>$request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->delete())
        {
           return response()->json(['success'=>'done']);
        } 
        else
        {
           return response()->json(['error'=>'Failed']); 
        }
    }
// Update location
    public function updatelocation(Request $request,$id = null)
    {
        // return $id;
        $id = $request->id;
        $data = district_model::select('id','state_model_id','name')->orderBy('name','asc')->where('state_model_id',$id)->get();
        return Response()->json([$data]);
    } 

    public function userprofile($id)
    {
        $data['profile'] = User::with('designation_model','district_model','state_model')->find($id);
        return view('users.user-profile')->with($data);
    }   
}
