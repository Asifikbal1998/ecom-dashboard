<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SubadminRole;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    /**
     * Display a listing of the brands.
     *
     */
    public function banners() {
        Session::put('page', 'banners');
        $banners = Banner::all();
        // Check the admin/subadmin's permissions for the Categories module
        $bannersModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->count();
        $brandsModule = array();

        // Grant full access to admin users
        if (Auth::guard('admin')->user()->type == 'admin') {
            $bannersModule['view_access'] = 1;
            $bannersModule['edit_access'] = 1;
            $bannersModule['full_access'] = 1;
        } elseif ($bannersModuleCount == 0) {
            // Restrict access if the user does not have permissions
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_meaasge', $message);
        } else {
            // Get the specific permissions for the subadmin
            $bannersModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->first()->toArray();
        }
        return view('admin.banners.banner')->with(compact('banners', 'bannersModule'));
    }


    /**
     * Show the form for creating a new brand.
     *
     */
    public function bannerCreate()
    {
        return view('admin.banners.banner_create');
    }


    /**
     * Store a newly created brand in storage.
     *
     */
    public function bannerStore(Request $request)
    {
        $data = $request->all();

        if ($request->isMethod('post')) {
            // Define validation rules and custom error messages
            $rule = [
                'image' => 'required',
                'type'   => 'required|regex:/^[\pL\s\-]+$/u|max:200'
            ];

            $customMessage = [
                'image.required' => 'Banner image is required',
                'type.required' => 'Banner Type is required',
                'type.regex' => 'Valid banner type name is required',
                'type.max' => 'Banner type name Should be less than 200 characters',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            $banners = new Banner();

            // Handle brand image upload
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/banner_image'), $imageName);
                $banners->image = $imageName;
            }

            // Assign banner data
            $banners->type = $request->type;
            $banners->link = $request->link;
            $banners->title = $request->title;
            $banners->alt = $request->alt;
            $banners->sort = $request->sort;
            $banners->status = 1;
            $banners->save();

            return redirect(route('banner.index'))->with(['success_message' => 'Banner has been created successfully']);
        } else {
            return redirect(route('banner.index'))->with('error_message', 'Database Error');
        }
    }


    /**
     * Show the form for editing the specified banner.
     *
     */
    public function bannerShow($id)
    {
        $banners = Banner::find($id);
        return view('admin.banners.banner_update')->with(compact('banners'));
    }



    /**
     * Update the specified brand in storage.
     *
     */
    public function bannerEdit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // Define validation rules and custom error messages
            $rule = [
                'type'   => 'required|regex:/^[\pL\s\-]+$/u|max:200'
            ];

            $customMessage = [
                'type.required' => 'Banner Type is required',
                'type.regex' => 'Valid banner type name is required',
                'type.max' => 'Banner type name Should be less than 200 characters',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            $banners = Banner::find($id);

            // Handle brand image upload
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/banner_image'), $imageName);
                $banners->image = $imageName;
            }

            // Assign banner data
            $banners->type = $request->type;
            $banners->link = $request->link;
            $banners->title = $request->title;
            $banners->alt = $request->alt;
            $banners->sort = $request->sort;
            $banners->status = 1;
            $banners->save();

            return redirect(route('banner.index'))->with(['success_message' => 'Banner has been Updated successfully']);
        } else {
            return redirect(route('banner.index'))->with('error_message', 'Database Error');
        }
    }



    /**
     * Remove the specified brand from storage.
     *
     */
    public function bannerDestry($id)
    {
        $bannerDelete = Banner::find($id);
        if (!empty($bannerDelete)) {
            $bannerDelete->delete();
            return redirect()->back()->with('success_message', 'Banner has been deleted successfully');
        } else {
            return redirect()->back()->with('error_message', 'This Banner does not exist in the database');
        }
    }



    /**
     * Toggle the status of the specified banner.
     *
     */
    public function bannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = ($data['status'] == 'Active') ? 0 : 1;
            Banner::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }



    /**
     * Remove the image of the specified brand.
     *
     */
    public function bannerImageDelete($id)
    {
        // Get brand by ID
        $banner = Banner::find($id);

        if (!$banner) {
            return redirect()->back()->with('error_message', 'Banner not found');
        }

        $bannerImage = $banner->image;
        $bannerImagePath = public_path('catalogues/banner_image/');

        // Delete brand image if it exists
        if ($bannerImage && file_exists($bannerImagePath . $bannerImage)) {
            unlink($bannerImagePath . $bannerImage);
        }

        // Update brand image to null
        $banner->update(['image' => null]);

        return redirect()->back()->with('success_message', 'Brand image has been deleted successfully');
    }
}
