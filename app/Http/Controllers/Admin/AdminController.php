<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        //session put for live page
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rule = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30'
            ];

            $customMessage = [
                'email.required' => 'Email Is required',
                'email.email' => 'valid email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rule, $customMessage);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {

                // Remember admin email & password with coockies
                if (isset($data['remember'])  &&  !empty($data['remember'])) {
                    setcookie('email', $data['email'], time() + 3600);
                    setcookie('password', $data['password'], time() + 3600);
                } else {
                    setcookie('email', '');
                    setcookie('password', '');
                }



                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Username or Password');
            }
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //Check the current password is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                // Check if new password and current password are same
                if ($data['new_password'] == $data['confirm_password']) {
                    //update new password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Your password has been change successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Your New Password anf Confirm password is not matching');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your current Password is Incorrect');
            }
        }
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();

        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updateDetails(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rule = [
                'name' => 'required|max:255',
                'mobile' => 'required|numeric|digits:10',
                'image' => 'image',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.max' => 'Name Maximum charcter less than 355',
                'mobile.required' => 'Mobile No. is required',
                'mobile.numeric' => 'Mobile No. only Numeric value Accepcted',
                'mobile.digits' => 'Valid Mobile no required',
                'image.image' => 'Valid Image is requried',
            ];

            $this->validate($request, $rule, $customMessage);

            //upload admin image
            // if($request->hasFile('image')) {
            //     $image_tmp = $request->file('image');
            //     if($image_tmp->isValid()) {
            //         //get image extension
            //         $extension = $image_tmp->getClientOriginalExtension();
            //         $imageName = rand(111,99999).''.$extension;
            //         $image_path = 'admin-asset/dist/img/photos/'.$imageName;
            //         Image::make($image_tmp)->save($image_path);
            //     }
            // }

            //updtaes admin details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['name'], 'mobile' => $data['mobile']]);
            return redirect()->back()->with('success_message', 'Admin details has been Update successfully');
        }
    }

    public function subadminIndex()
    {
        Session::put('page', 'subadmin');
        $subadmins = Admin::where('type', 'subadmin')->get();
        return view('admin.subadmin.subadmin')->with('subadmins', $subadmins);
    }

    public function subadminCreate()
    {
        return view('admin.subadmin.subadmin_create');
    }

    public function subadminStore(Request $request)
    {

        if ($request->isMethod('post')) {

            $rule = [
                'name' => 'required|max:255',
                'type' => 'required',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'password' => 'required',
                'image' => 'nullable|mimes:png,jpg,gif',

            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.max' => 'Name Maximum charcter less than 355',
                'mobile.required' => 'Mobile No. is required',
                'mobile.numeric' => 'Mobile No. only Numeric value Accepcted',
                'mobile.digits' => 'Valid Mobile no required',
                'image.mimes' => 'Valid Image is requried',
                'password.reuired' => 'Password is required',
            ];

            $val = $this->validate($request, $rule, $customMessage);

            if (!empty($val)) {

                $password = bcrypt($request->password);
                $subadmins = new Admin();

                //upload image if user select a image
                if (isset($request->image)) {
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('subadmin'), $imageName);
                    $subadmins->image = $imageName;
                }


                $subadmins->name = $request->name;
                $subadmins->type = $request->type;
                $subadmins->mobile = $request->mobile;
                $subadmins->email = $request->email;
                $subadmins->password = $password;
                $subadmins->status = $request->status;
                $subadmins->save();

                return redirect(route('subadmin'))->with('success_message', 'Subadmin has been Created successfully');
            } else {
                return redirect(route('subadmin'))->with('error_message', 'Database Error');
            }
        }
    }

    public function subadminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function subadminDestry($id)
    {
        $subadmin = Admin::find($id);
        if (!empty($subadmin)) {
            $subadmin->delete();
            return redirect()->back()->with('success_message', 'Page is deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'This page not exist in Database');
        }
    }

    public function subadminShow($id)
    {
        $subadmin = Admin::find($id);
        return view('admin.subadmin.subadmin_update')->with('subadmin', $subadmin);
    }

    public function subadminEdit($id, Request $request)
    {
        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // die;

        if ($request->isMethod('post')) {

            $rule = [
                'name' => 'required|max:255',
                'type' => 'required',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'password' => 'required',
                'image' => 'nullable|mimes:png,jpg,gif',

            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.max' => 'Name Maximum charcter less than 355',
                'mobile.required' => 'Mobile No. is required',
                'mobile.numeric' => 'Mobile No. only Numeric value Accepcted',
                'mobile.digits' => 'Valid Mobile no required',
                'image.mimes' => 'Valid Image is requried',
                'password.reuired' => 'Password is required',
            ];

            $val = $this->validate($request, $rule, $customMessage);

            if (!empty($val)) {

                $password = bcrypt($request->password);
                $subadmins = Admin::find($id);

                //upload image if image is set
                if (isset($request->image)) {
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('subadmin'), $imageName);
                    $subadmins->image = $imageName;
                }


                $subadmins->name = $request->name;
                $subadmins->type = $request->type;
                $subadmins->mobile = $request->mobile;
                $subadmins->email = $request->email;
                $subadmins->password = $password;
                $subadmins->status = $request->status;

                $subadmins->save();

                return redirect(route('subadmin'))->with('success_message', 'Subadmin Details has been Updated successfully');
            } else {
                return redirect(route('subadmin'))->with('error_message', 'Database Error');
            }
        }
    }
}
