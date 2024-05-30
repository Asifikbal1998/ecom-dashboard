<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SubadminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // Display the admin dashboard
    public function index()
    {
        Session::put('page', 'dashboard'); // Set session page to 'dashboard'
        return view('admin.dashboard'); // Return the dashboard view
    }

    // Handle admin login
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // Define validation rules and custom messages
            $rule = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30'
            ];

            $customMessage = [
                'email.required' => 'Email is required',
                'email.email' => 'A valid email is required',
                'password.required' => 'Password is required',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            // Attempt to authenticate the admin
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {

                // Remember admin email & password with cookies if 'remember' is checked
                if (isset($data['remember']) && !empty($data['remember'])) {
                    setcookie('email', $data['email'], time() + 3600); // 1 hour
                    setcookie('password', $data['password'], time() + 3600); // 1 hour
                } else {
                    setcookie('email', '');
                    setcookie('password', '');
                }

                return redirect('admin/dashboard'); // Redirect to the dashboard on successful login
            } else {
                return redirect()->back()->with('error_message', 'Invalid Username or Password'); // Redirect back with error message
            }
        }
    }

    // Handle admin logout
    public function logout()
    {
        Auth::guard('admin')->logout(); // Log out the admin
        return redirect('admin/login'); // Redirect to login page
    }

    // Update admin password
    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // Check if the current password matches
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {

                // Verify if the new password and confirm password match
                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)
                        ->update(['password' => bcrypt($data['new_password'])]); // Update with new password
                    return redirect()->back()->with('success_message', 'Your password has been changed successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Your New Password and Confirm Password do not match');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your current Password is Incorrect');
            }
        }
    }

    // Check if the current password is correct (AJAX)
    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();

        // Return 'true' if the password is correct, 'false' otherwise
        return Hash::check($data['current_password'], Auth::guard('admin')->user()->password) ? 'true' : 'false';
    }

    // Update admin details
    public function updateDetails(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // dd($data);

            // Define validation rules and custom messages
            $rule = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'mobile' => 'required|numeric|digits:10',
                'image' => 'image',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.regex' => 'A valid name is required',
                'name.max' => 'Name should not exceed 255 characters',
                'mobile.required' => 'Mobile number is required',
                'mobile.numeric' => 'Mobile number should be numeric',
                'mobile.digits' => 'Mobile number should be 10 digits',
                'image.image' => 'A valid image is required',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            // Upload admin image if exists
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('subadmin'), $imageName);
                Admin::where('email', Auth::guard('admin')->user()->email)
                    ->update(['image' => $imageName]);
            }

            // Update admin details
            Admin::where('email', Auth::guard('admin')->user()->email)
                ->update(['name' => $data['name'], 'mobile' => $data['mobile']]);
            return redirect()->back()->with('success_message', 'Admin details have been updated successfully');
        }
    }

    // Display subadmin management page
    public function subadminIndex()
    {
        Session::put('page', 'subadmin'); // Set session page to 'subadmin'
        $subadmins = Admin::where('type', 'subadmin')->get(); // Get all subadmins
        return view('admin.subadmin.subadmin')->with('subadmins', $subadmins); // Return view with subadmins data
    }

    // Display subadmin creation form
    public function subadminCreate()
    {
        return view('admin.subadmin.subadmin_create'); // Return subadmin creation view
    }

    // Store new subadmin details
    public function subadminStore(Request $request)
    {
        if ($request->isMethod('post')) {
            // Check if the email already exists
            $isEmailExist = Admin::where('email', $request->email)->exists();
            if ($isEmailExist) {
                return redirect(route('subadmin'))->with('error_message', 'Subadmin already exists');
            }

            // Define validation rules and custom messages
            $rule = [
                'name' => 'required|max:255',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'password' => 'required',
                'image' => 'nullable|mimes:png,jpg,gif',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.max' => 'Name should not exceed 255 characters',
                'mobile.required' => 'Mobile number is required',
                'mobile.numeric' => 'Mobile number should be numeric',
                'mobile.digits' => 'Mobile number should be 10 digits',
                'image.mimes' => 'A valid image is required',
                'password.required' => 'Password is required',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            // Encrypt the password
            $password = bcrypt($request->password);
            $subadmin = new Admin();

            // Upload image if selected
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('subadmin'), $imageName);
                $subadmin->image = $imageName;
            }

            // Save subadmin details
            $subadmin->name = $request->name;
            $subadmin->type = 'subadmin';
            $subadmin->mobile = $request->mobile;
            $subadmin->email = $request->email;
            $subadmin->password = $password;
            $subadmin->save();

            return redirect(route('subadmin'))->with('success_message', 'Subadmin has been created successfully');
        }
    }

    // Update subadmin status (AJAX)
    public function subadminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = ($data['status'] == 'Active') ? 0 : 1; // Toggle status
            Admin::where('id', $data['page_id'])->update(['status' => $status]); // Update status
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]); // Return response
        }
    }

    // Delete a subadmin
    public function subadminDestroy($id)
    {
        $subadmin = Admin::find($id);
        if (!empty($subadmin)) {
            $subadmin->delete(); // Delete the subadmin
            return redirect()->back()->with('success_message', 'Subadmin is deleted successfully');
        } else {
            return redirect()->back()->with('error_message', 'Subadmin does not exist in the database');
        }
    }

    // Show subadmin details for update
    public function subadminShow($id)
    {
        $subadmin = Admin::find($id); // Find subadmin by ID
        return view('admin.subadmin.subadmin_update')->with('subadmin', $subadmin); // Return view with subadmin data
    }

    // Edit subadmin details
    public function subadminEdit($id, Request $request)
    {
        if ($request->isMethod('post')) {
            // Define validation rules and custom messages
            $rule = [
                'name' => 'required|max:255',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'password' => 'required',
                'image' => 'nullable|mimes:png,jpg,gif',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.max' => 'Name should not exceed 255 characters',
                'mobile.required' => 'Mobile number is required',
                'mobile.numeric' => 'Mobile number should be numeric',
                'mobile.digits' => 'Mobile number should be 10 digits',
                'image.mimes' => 'A valid image is required',
                'password.required' => 'Password is required',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            // Encrypt the password
            $password = bcrypt($request->password);
            $subadmin = Admin::find($id);

            // Upload image if selected
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('subadmin'), $imageName);
                $subadmin->image = $imageName;
            }

            // Update subadmin details
            $subadmin->name = $request->name;
            $subadmin->mobile = $request->mobile;
            $subadmin->email = $request->email;
            $subadmin->password = $password;
            $subadmin->save();

            return redirect(route('subadmin'))->with('success_message', 'Subadmin details have been updated successfully');
        } else {
            return redirect(route('subadmin'))->with('error_message', 'Database error');
        }
    }

    // View subadmin permissions
    public function subadminPermisionView($id)
    {
        $data = SubadminRole::where('subadmin_id', $id)->get()->toArray(); // Get subadmin roles
        $name = Admin::select('name')->where('id', $id)->first()->toArray(); // Get subadmin name
        return view('admin.subadmin.subadmin_role')->with(['data' => $data, 'name' => $name, 'id' => $id]); // Return view with data
    }

    // Update subadmin permissions
    public function subadminPermisionGive($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            // Delete all previous roles for the subadmin
            SubadminRole::where('subadmin_id', $id)->delete();

            // Add new roles for the subadmin
            foreach ($data as $key => $value) {
                $view = isset($value['view']) ? $value['view'] : 0;
                $edit = isset($value['edit']) ? $value['edit'] : 0;
                $full = isset($value['full']) ? $value['full'] : 0;

                $role = new SubadminRole();
                $role->subadmin_id = $id;
                $role->module = $key;
                $role->view_access = $view;
                $role->edit_access = $edit;
                $role->full_access = $full;
                $role->save();
            }

            $success_message = "Subadmin role has been given/updated successfully";
            return redirect(route('subadminpermision.view', ['id' => $id]))->with(compact('success_message'));
        }
    }

    // delete subadmin image
    public function subadminImageDelete($id)
    {
        // Get brand by ID
        $subadmin = Admin::find($id);

        if (!$subadmin) {
            return redirect()->back()->with('error_message', 'Image is not found');
        }

        $subadminImage = $subadmin->image;
        $subadminImagePath = public_path('subadmin/');

        // Delete brand image if it exists
        if ($subadminImage && file_exists($subadminImagePath . $subadminImage)) {
            unlink($subadminImagePath . $subadminImage);
        }

        // Update brand image to null
        $subadmin->update(['image' => null]);

        return redirect()->back()->with('success_message', 'Subadmin image has been deleted successfully');
    }
    // delete subadmin image
}
