<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SubadminRole;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Display the list of categories
    public function categories()
    {
        // Set the current page to 'category' in the session
        Session::put('page', 'category');

        // Retrieve all categories with their parent categories
        $categories = Category::with('parentcategory')->get();

        // Check the admin/subadmin's permissions for the Categories module
        $categoriesModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->count();
        $categoriesModule = array();

        // Grant full access to admin users
        if (Auth::guard('admin')->user()->type == 'admin') {
            $categoriesModule['view_access'] = 1;
            $categoriesModule['edit_access'] = 1;
            $categoriesModule['full_access'] = 1;
        } elseif ($categoriesModuleCount == 0) {
            // Restrict access if the user does not have permissions
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_meaasge', $message);
        } else {
            // Get the specific permissions for the subadmin
            $categoriesModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->first()->toArray();
        }

        // Return the view with categories and permissions
        return view('admin.categories.categories')->with(compact('categories', 'categoriesModule'));
    }

    // Toggle category status (Active/Inactive)
    public function categoriesStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = ($data['status'] == 'Active') ? 0 : 1;

            // Update the category status
            Category::where('id', $data['page_id'])->update(['status' => $status]);

            // Return the new status and category ID as JSON response
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    // Display the form to create a new category
    public function categoryCreate()
    {
        // Get categories with their subcategories for the dropdown
        $category = new Category();
        $getCategories = $category->getCategoriesWithSubcategories()->toArray();

        // Return the view with the categories data
        return view('admin.categories.category_create')->with(compact('getCategories'));
    }

    // Store a newly created category in the database
    public function categoryStore(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            // Validation rules and custom error messages
            $rule = [
                'category_name' => 'required|max:255',
                'category_discount' => 'nullable|numeric',
                'description' => 'nullable|max:300',
                'url' => 'required',
                'meta_title' => 'nullable|max:100',
                'meta_description' => 'nullable|max:150',
                'meta_keyword' => 'nullable|max:150',
                'image' => 'nullable|mimes:png,jpg,gif',
            ];

            $customMessage = [
                'category_name.required' => 'Category name is required',
                'category_name.max' => 'Category name should be less than 255 characters',
                'category_discount.numeric' => 'Category discount should be a numeric value',
                'description.max' => 'Description should be less than 300 characters',
                'url.required' => 'Category URL is required',
                'meta_title.max' => 'Meta title should be less than 100 characters',
                'meta_description.max' => 'Meta description should be less than 150 characters',
                'meta_keyword.max' => 'Meta keyword should be less than 150 characters',
                'image.mimes' => 'Valid image formats are png, jpg, and gif',
            ];

            // Validate the request data
            $this->validate($request, $rule, $customMessage);

            $category = new Category();

            // Upload image if it exists
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/category_image'), $imageName);
                $category->categori_image = $imageName;
            }

            //Remove Brand Discount from all products belongs to specific Brand
            if (empty($data['brand_discount'])) {
                $data['brand_discount'] = 0;
                if ($id != "") {
                    $brandProducts = Product::where('brand_id', $id)->get()->toArray();
                    foreach ($brandProducts as $key => $product) {
                        if ($product['discount_type'] == "category") {
                            Product::where('id', $product['id'])->update(['discount_type' => '', 'final_price' => $product['product_price']]);
                        }
                    }
                }
            }

            // Save category details
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

            // Redirect with success message
            return redirect(route('category'))->with('success_message', 'Category has been created successfully');
        } else {
            // Redirect with error message if the request method is not POST
            return redirect(route('subadmin'))->with('error_message', 'Database error');
        }
    }

    // Display the form to edit an existing category
    public function categoryShow($id)
    {
        // Get categories with their subcategories for the dropdown
        $category = new Category();
        $getCategories = $category->getCategoriesWithSubcategories()->toArray();

        // Find the category by ID
        $categories = Category::find($id)->toArray();

        // Return the view with the category data
        return view('admin.categories.category_update')->with(['categories' => $categories, 'getCategories' => $getCategories]);
    }

    // Update the category in the database
    public function categoryEdit($id, Request $request)
    {
        if ($request->isMethod('post')) {
            // Validation rules and custom error messages
            $rule = [
                'category_name' => 'required|max:255',
                'category_discount' => 'nullable|numeric',
                'description' => 'nullable|max:300',
                'url' => 'required',
                'meta_title' => 'nullable|max:100',
                'meta_description' => 'nullable|max:150',
                'meta_keyword' => 'nullable|max:150',
                'image' => 'nullable|mimes:png,jpg,gif',
            ];

            $customMessage = [
                'category_name.required' => 'Category name is required',
                'category_name.max' => 'Category name should be less than 255 characters',
                'category_discount.numeric' => 'Category discount should be a numeric value',
                'description.required' => 'Category Description is required',
                'url.required' => 'Category URL is required',
                'meta_title.max' => 'Meta title should be less than 100 characters',
                'meta_description.max' => 'Meta description should be less than 150 characters',
                'meta_keyword.max' => 'Meta keyword should be less than 150 characters',
                'image.mimes' => 'Valid image formats are png, jpg, and gif',
            ];

            // Validate the request data
            $this->validate($request, $rule, $customMessage);

            // Find the category by ID
            $category = Category::find($id);

            // Upload image if it exists
            if (isset($request->image)) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('catalogues/category_image'), $imageName);
                $category->categori_image = $imageName;
            }

            //Remove Brand Discount from all products belongs to specific Brand
            if (empty($data['brand_discount'])) {
                $data['brand_discount'] = 0;
                if ($id != "") {
                    $brandProducts = Product::where('brand_id', $id)->get()->toArray();
                    foreach ($brandProducts as $key => $product) {
                        if ($product['discount_type'] == "category") {
                            Product::where('id', $product['id'])->update(['discount_type' => '', 'final_price' => $product['product_price']]);
                        }
                    }
                }
            }

            // Update category details
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

            // Redirect with success message
            return redirect(route('category'))->with('success_message', 'Category has been updated successfully');
        } else {
            // Redirect with error message if the request method is not POST
            return redirect(route('subadmin'))->with('error_message', 'Database error');
        }
    }

    // Delete a category from the database
    public function categoryDestry($id)
    {
        // Find the category by ID
        $category = Category::find($id);

        if (!empty($category)) {
            // Delete the category
            $category->delete();
            return redirect()->back()->with('success_message', 'Category is deleted successfully');
        } else {
            // Redirect with error message if the category does not exist
            return redirect()->back()->with('error_message', 'This category does not exist in the database');
        }
    }

    // Delete the image associated with a category
    public function categoryImageDelete($id)
    {
        // Find the category by ID
        $category = Category::find($id);

        if (!$category) {
            // Redirect with error message if the category is not found
            return redirect()->back()->with('error_message', 'Category not found');
        }

        // Get the category image
        $categoryImage = $category->categori_image;

        // Define the category image path
        $category_Image_Path = public_path('catalogues/category_image/');

        // Delete the category image from the public catalogues folder if it exists
        if ($categoryImage && file_exists($category_Image_Path . $categoryImage)) {
            unlink($category_Image_Path . $categoryImage);
        }

        // Remove the image from the category table
        $category->update(['categori_image' => null]);

        // Redirect with success message
        return redirect()->back()->with('success_message', 'Category image is deleted successfully');
    }
}
