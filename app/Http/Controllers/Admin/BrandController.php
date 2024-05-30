<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\SubadminRole;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the brands.
     *
     * @return \Illuminate\View\View
     */
    public function brand()
    {
        Session::put('page', 'brand');
        $brands = Brand::all();
        // Check the admin/subadmin's permissions for the Categories module
        $brandsModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->count();
        $brandsModule = array();

        // Grant full access to admin users
        if (Auth::guard('admin')->user()->type == 'admin') {
            $brandsModule['view_access'] = 1;
            $brandsModule['edit_access'] = 1;
            $brandsModule['full_access'] = 1;
        } elseif ($brandsModuleCount == 0) {
            // Restrict access if the user does not have permissions
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_meaasge', $message);
        } else {
            // Get the specific permissions for the subadmin
            $brandsModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->first()->toArray();
        }

        return view('admin.brands.brand')->with(compact('brands','brandsModule'));
    }

    /**
     * Show the form for creating a new brand.
     *
     * @return \Illuminate\View\View
     */
    public function brandCreate()
    {
        return view('admin.brands.brand_create');
    }

    /**
     * Store a newly created brand in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function brandStore(Request $request, $id = null)
    {
        $data = $request->all();

        if ($request->isMethod('post')) {
            // Define validation rules and custom error messages
            $rule = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'url'   => 'required|unique:brands'
            ];

            $customMessage = [
                'brand_name.required' => 'Brand name is required',
                'brand_name.regex' => 'Valid brand name is required',
                'brand_name.max' => 'Brand name must be less than 200 characters',
                'url.required' => 'URL is required',
                'url.unique' => 'URL must be unique',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            $brands = new Brand();

            // Handle brand image upload
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/brand_images/image'), $imageName);
                $brands->brand_image = $imageName;
            }

            // Handle brand logo upload
            if (isset($request->brand_logo)) {
                $imageName2 = time() . '.' . $request->brand_logo->extension();
                $request->brand_logo->move(public_path('catalogues/brand_images/logo'), $imageName2);
                $brands->brand_logo = $imageName2;
            }

            //Remove Brand Discount from all products belongs to specific Brand
            if (empty($data['brand_discount'])) {
                $data['brand_discount'] = 0;
                if ($id != "") {
                    $brandProducts = Product::where('brand_id', $id)->get()->toArray();
                    foreach ($brandProducts as $key => $product) {
                        if ($product['discount_type'] == "brand") {
                            Product::where('id', $product['id'])->update(['discount_type' => '', 'final_price' => $product['product_price']]);
                        }
                    }
                }
            }

            // Assign brand data
            $brands->brand_id = $request->brand_id;
            $brands->brand_name = $request->brand_name;
            $brands->brand_discount = $request->brand_discount;
            $brands->description = $request->description;
            $brands->url = $request->url;
            $brands->meta_title = $request->meta_title;
            $brands->meta_keywords = $request->meta_keywords;
            $brands->meta_description = $request->meta_description;
            $brands->website = $request->website;
            $brands->email = $request->email;
            $brands->phone = $request->phone;
            $brands->address = $request->address;
            $brands->status = 1;
            $brands->save();

            return redirect(route('brand.index'))->with(['success_message' => 'Brand has been created successfully']);
        } else {
            return redirect(route('brand.index'))->with('error_message', 'Database Error');
        }
    }

    /**
     * Show the form for editing the specified brand.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function brandShow($id)
    {
        $brands = Brand::find($id);
        return view('admin.brands.brand_update')->with(compact('brands'));
    }

    /**
     * Update the specified brand in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function brandEdit(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        if ($request->isMethod('post')) {
            // Define validation rules and custom error messages
            $rule = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
            ];

            $customMessage = [
                'brand_name.required' => 'Brand name is required',
                'brand_name.regex' => 'Valid brand name is required',
                'brand_name.max' => 'Brand name must be less than 200 characters',
            ];

            // Validate the request
            $this->validate($request, $rule, $customMessage);

            $brands = Brand::find($id);

            // Handle brand image upload
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/brand_images/image'), $imageName);
                $brands->brand_image = $imageName;
            }

            // Handle brand logo upload
            if (isset($request->brand_logo)) {
                $imageName2 = time() . '.' . $request->brand_logo->extension();
                $request->brand_logo->move(public_path('catalogues/brand_images/logo'), $imageName2);
                $brands->brand_logo = $imageName2;
            }

            //Remove Brand Discount from all products belongs to specific Brand
            if (empty($data['brand_discount'])) {
                $data['brand_discount'] = 0;
                if ($id != "") {
                    $brandProducts = Product::where('brand_id', $id)->get()->toArray();
                    foreach ($brandProducts as $key => $product) {
                        if ($product['discount_type'] == "brand") {
                            Product::where('id', $product['id'])->update(['discount_type' => '', 'final_price' => $product['product_price']]);
                        }
                    }
                }
            }

            // Assign brand data
            $brands->brand_id = $request->brand_id;
            $brands->brand_name = $request->brand_name;
            $brands->brand_discount = $request->brand_discount;
            $brands->description = $request->description;
            $brands->url = $request->url;
            $brands->meta_title = $request->meta_title;
            $brands->meta_keywords = $request->meta_keywords;
            $brands->meta_description = $request->meta_description;
            $brands->website = $request->website;
            $brands->email = $request->email;
            $brands->phone = $request->phone;
            $brands->address = $request->address;
            $brands->status = 1;
            $brands->save();

            return redirect(route('brand.index'))->with(['success_message' => 'Brand has updated successfully']);
        } else {
            return redirect(route('brand.index'))->with('error_message', 'Database Error');
        }
    }

    /**
     * Remove the specified brand from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function brandDestry($id)
    {
        $brandDelete = Brand::find($id);
        if (!empty($brandDelete)) {
            $brandDelete->delete();
            return redirect()->back()->with('success_message', 'Brand has been deleted successfully');
        } else {
            return redirect()->back()->with('error_message', 'This brand does not exist in the database');
        }
    }

    /**
     * Toggle the status of the specified brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function brandStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = ($data['status'] == 'Active') ? 0 : 1;
            Brand::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    /**
     * Remove the image of the specified brand.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function brandImageDelete($id)
    {
        // Get brand by ID
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->back()->with('error_message', 'Brand not found');
        }

        $brandImage = $brand->brand_image;
        $brandImagePath = public_path('catalogues/brand_images/image/');

        // Delete brand image if it exists
        if ($brandImage && file_exists($brandImagePath . $brandImage)) {
            unlink($brandImagePath . $brandImage);
        }

        // Update brand image to null
        $brand->update(['brand_image' => null]);

        return redirect()->back()->with('success_message', 'Brand image has been deleted successfully');
    }

    /**
     * Remove the logo of the specified brand.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function brandLogoDelete($id)
    {
        // Get brand by ID
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->back()->with('error_message', 'Brand not found');
        }

        $brandLogo = $brand->brand_logo;
        $brandLogoPath = public_path('catalogues/brand_images/logo/');

        // Delete brand logo if it exists
        if ($brandLogo && file_exists($brandLogoPath . $brandLogo)) {
            unlink($brandLogoPath . $brandLogo);
        }

        // Update brand logo to null
        $brand->update(['brand_logo' => null]);

        return redirect()->back()->with('success_message', 'Brand logo has been deleted successfully');
    }
}
