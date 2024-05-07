<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SubadminRole;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Category View/Get
    public function categories()
    {
        Session::put('page', 'category');
        $categories = Category::with('parentcategory')->get();

        //set admin/subadmin role/permession for Categories
        $categoriesModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->count();
        $categoriesModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $categoriesModule['view_access'] = 1;
            $categoriesModule['edit_access'] = 1;
            $categoriesModule['full_access'] = 1;
        } elseif ($categoriesModuleCount == 0) {
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_meaasge', $message);
        } else {
            $categoriesModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->first()->toArray();
        }

        return view('admin.categories.categories')->with(compact('categories', 'categoriesModule'));
    }
    // Category View end

    // Category Status
    public function categoriesStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }
    // Category Status end


    // Add New Category Form View
    public function categoryCreate()
    {
        $category = new Category();
        $getCategories = $category->getCategoriesWithSubcategories()->toArray();
        return view('admin.categories.category_create')->with('getCategories', $getCategories);
    }
    // Add New Category Form View end


    // Store New Category
    public function categoryStore(Request $request)
    {
        if ($request->isMethod('post')) {

            $rule = [
                'category_name' => 'required|max:255',
                'category_discount' => 'nullable|numeric',
                'description' => 'nullable||max:300',
                'url' => 'required',
                'meta_title' => 'nullable||max:100',
                'meta_description' => 'nullable||max:150',
                'meta_keyword' => 'nullable||max:150',
                'image' => 'nullable|mimes:png,jpg,gif',
            ];

            $customMessage = [
                'category_name.required' => 'Category name is required',
                'category_name.max' => 'Category name Maximum charcter less than 355',
                'category_discount.numeric' => 'Category sdiscount only Numeric value Accepcted',
                'description.max' => 'Category Maximum charcter less than 300',
                'url.required' => 'Category url is required',
                'meta_title.max' => 'Category meta_title Maximum charcter less than 150',
                'meta_description.max' => 'Category meta_description Maximum charcter less than 150',
                'meta_keyword.max' => 'Category meta_keyword Maximum charcter less than 150',
                'image.mimes' => 'Valid Image is requried',
            ];

            $this->validate($request, $rule, $customMessage);



            $category = new Category();

            //upload image if image is set
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/category_image'), $imageName);
                $category->categori_image = $imageName;
            }


            $category->categori_name = $request->category_name;
            $category->parent_id = $request->parent_id;
            $category->categori_discount = $request->category_discount;
            $category->description = $request->description;
            $category->url = $request->url;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->meta_keywords = $request->meta_keyword;
            $category->status = 1;
            $category->save();

            return redirect(route('category'))->with(['success_message' => 'Category has been Created successfully']);
        } else {
            return redirect(route('subadmin'))->with('error_message', 'Database Error');
        }
    }
    // Store New Category end


    // Category Edit Form View
    public function categoryShow($id)
    {
        $category = new Category();
        $getCategories = $category->getCategoriesWithSubcategories()->toArray();
        $categories = Category::find($id)->toArray();
        return view('admin.categories.category_update')->with(['categories' => $categories, 'getCategories' => $getCategories]);
    }
    // Category Edit Form View end


    // After Categry Edit Category Store
    public function categoryEdit($id, Request $request)
    {
        if ($request->isMethod('post')) {

            $rule = [
                'category_name' => 'required|max:255',
                'category_discount' => 'nullable|numeric',
                'description' => 'nullable||max:300',
                'url' => 'required',
                'meta_title' => 'nullable||max:100',
                'meta_description' => 'nullable||max:150',
                'meta_keyword' => 'nullable||max:150',
                'image' => 'nullable|mimes:png,jpg,gif',
            ];

            $customMessage = [
                'category_name.required' => 'Category name is required',
                'category_name.max' => 'Category name Maximum charcter less than 355',
                'category_discount.numeric' => 'Category discount only Numeric value Accepcted',
                'description.required' => 'Category Description is required',
                'url.required' => 'Category url is required',
                'meta_title.max' => 'Category meta_title Maximum charcter less than 150',
                'meta_description.max' => 'Category meta_description Maximum charcter less than 150',
                'meta_keyword.max' => 'Category meta_keyword Maximum charcter less than 150',
                'image.mimes' => 'Valid Image is requried',
            ];

            $this->validate($request, $rule, $customMessage);



            $category = Category::find($id);

            //upload image if image is set
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/category_image'), $imageName);
                $category->categori_image = $imageName;
            }


            $category->categori_name = $request->category_name;
            $category->parent_id = $request->parent_id;
            $category->categori_discount = $request->category_discount;
            $category->description = $request->description;
            $category->url = $request->url;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->meta_keywords = $request->meta_keyword;
            $category->status = 1;
            $category->save();

            return redirect(route('category'))->with('success_message', 'Category has been Updated successfully');
        } else {
            return redirect(route('subadmin'))->with('error_message', 'Database Error');
        }
    }
    // After Categry Edit Category Store end


    // Category Delete
    public function categoryDestry($id)
    {
        $category = Category::find($id);
        if (!empty($category)) {
            $category->delete();
            return redirect()->back()->with('success_message', 'Category is deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'This category not exist in Database');
        }
    }
    // Category Delete end


    // Category Image Delete
    public function categoryImageDelete($id)
    {
        // get category image
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with('error_message', 'Category not found');
        }

        $categoryImage = $category->categori_image;

        // get category image path
        $category_Image_Path = public_path('catalogues/category_image/');

        // Delete category image from public catalogues folder if exist
        if ($categoryImage && file_exists($category_Image_Path . $categoryImage)) {
            unlink($category_Image_Path . $categoryImage);
        }

        // Delete category image from category table
        $category->update(['categori_image' => null]);

        return redirect()->back()->with('success_message', 'Category Image is deleted Successfully');
    }
    // Category Image Delete end
}
