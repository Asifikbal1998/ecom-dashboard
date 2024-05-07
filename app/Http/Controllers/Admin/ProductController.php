<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\SubadminRole;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //Product View/Get
    public function product()
    {
        Session::put('page', 'products');
        $products = Product::with('category')->get();

        //set admin/subadmin role/permession for product page
        $productModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'product'])->count();
        $productModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $productModule['view_access'] = 1;
            $productModule['edit_access'] = 1;
            $productModule['full_access'] = 1;
        } elseif ($productModuleCount == 0) {
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_meaasge', $message);
        } else {
            $productModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'product'])->first()->toArray();
        }

        return view('admin.products.products')->with(compact('products', 'productModule'));
    }
    //Product View end

    //Add New Product Form View
    public function productCreate()
    {
        //get category && sub category
        $category = new Category();
        $getCategories = $category->getCategoriesWithSubcategories()->toArray();
        //get product filter
        $productFilters = Product::productFilters();
        //get family colr
        $familyColors = Color::all()->where('status', 1);
        return view('admin.products.product_create')->with(compact('productFilters', 'getCategories', 'familyColors'));
    }
    // Add New Product Form View end

    //Add New Product Store
    public function productStore(Request $request)
    {

        if ($request->isMethod('post')) {

            //validation
            $rule = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_code' => 'required|regex:/^[\w-]*$/|max:30',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'family_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_price' => 'required|numeric',
            ];

            $customMessage = [
                'category_id.required' => 'Category Id is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_name.max' => 'Product Name should be less than 200 characters',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_code.max' => 'Product code should be less than 30 characters',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
                'product_color.msx' => 'Product Color should be less than 200 characters',
                'family_color.required' => 'Family Color is required',
                'family_color.regex' => 'Valid Family Color is required',
                'family_color.max' => 'Familly Color should be less than 200 characters',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'OnlY allow integer value',
            ];

            $this->validate($request, $rule, $customMessage);



            $product = new Product();

            // Upload video if Product Video is set
            if ($request->hasFile('product_video')) {
                $videoName = time() . '.' . $request->product_video->extension();
                $request->product_video->move(public_path('catalogues/product_video'), $videoName);
                $product->product_video = $videoName;
            }

            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->product_color = $request->product_color;
            $product->family_color = $request->family_color;
            $product->group_code = $request->group_code;
            $product->product_price = $request->product_price;


            //check if product/category discount is set and then strore to datebase
            if (isset($request->product_discount)  && $request->product_discount > 0) {
                $product->product_discount = $request->product_discount;
                $product->discount_type = 'product';

                //calculate percentage
                $product_price = $request->product_price; // Original price of the product
                $product_discount = $request->product_discount; // Discount percentage
                $final_price = $product_price - ($product_discount / 100 * $product_price);
                // Assign the final price to the product
                $product->final_price = $final_price;
            } else {
                $product->product_discount = 0;
                $get_category_discount = Category::select('categori_discount')->where('id', $request->category_id)->first();
                if ($get_category_discount->categori_discount == 0) {
                    $product->product_discount = 0;
                    $product->discount_type = '';
                    $product_price = $request->product_price; // Original price of the product
                    $product->final_price = $product_price;
                } else {
                    $product->product_discount = $get_category_discount->categori_discount;
                    $product->discount_type = 'category';
                    $product_price = $request->product_price; // Original price of the product
                    $final_price = $product_price - ($get_category_discount->categori_discount / 100 * $product_price);
                    $product->final_price = $final_price;
                }
            }



            $product->product_weight = $request->product_weight;
            $product->description = $request->description;
            $product->wash_care = $request->wash_care;
            $product->search_keywords = $request->search_keywords;
            $product->fabric = $request->fabric;
            $product->fit = $request->fit;
            $product->occassion = $request->occasion;
            $product->sleeve = $request->sleeve;
            $product->pattern = $request->pattern;
            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keywords = $request->meta_keyword;
            //Is Featured condition
            if ($request->is_featured == 1) {
                $product->is_featured = 'yes';
            }
            if ($request->is_featured == 0) {
                $product->is_featured = 'no';
            }
            $product->status = 1;
            $product->save();

            return redirect(route('product.index'))->with(['success_message' => 'Category has been Created successfully']);
        } else {
            return redirect(route('product.index'))->with('error_message', 'Database Error');
        }
    }
    //Add New Product Store End

    //Product Edit Form View
    public function productShow($id)
    {
        $category = new Category();
        $getCategories = $category->getCategoriesWithSubcategories()->toArray();
        // dd($getCategories);
        $product = Product::find($id);
        //product filter get
        $productFilters = Product::productFilters();
        //get family colr
        $familyColors = Color::all()->where('status', 1);
        if (!empty($product)) {
            return view('admin.products.product_update')->with(compact('product', 'getCategories', 'productFilters', 'familyColors'));
        }
    }
    //Product Edit Form View End

    //After Product Edit .... Product Store
    public function productEdit($id, Request $request)
    {

        if ($request->isMethod('post')) {

            //validation
            $rule = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_code' => 'required|regex:/^[\w-]*$/|max:30',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'family_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_price' => 'required|numeric',
            ];

            $customMessage = [
                'category_name.id' => 'Category Id is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_name.max' => 'Product Name should be less than 200 characters',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_code.max' => 'Product code should be less than 30 characters',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
                'product_color.msx' => 'Product Color should be less than 200 characters',
                'family_color.required' => 'Family Color is required',
                'family_color.regex' => 'Valid Family Color is required',
                'family_color.max' => 'Familly Color should be less than 200 characters',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'OnlY allow integer value',
            ];

            $this->validate($request, $rule, $customMessage);



            $product = Product::find($id);

            // Upload video if Product Video is set
            if ($request->hasFile('product_video')) {
                $videoName = time() . '.' . $request->product_video->extension();
                $request->product_video->move(public_path('catalogues/product_video'), $videoName);
                $product->product_video = $videoName;
            }

            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->product_color = $request->product_color;
            $product->family_color = $request->family_color;
            $product->group_code = $request->group_code;
            $product->product_price = $request->product_price;


            //check if product/category discount is set and then strore to datebase
            if (isset($request->product_discount)  && $request->product_discount > 0) {
                $product->product_discount = $request->product_discount;
                $product->discount_type = 'product';

                //calculate percentage
                $product_price = $request->product_price; // Original price of the product
                $product_discount = $request->product_discount; // Discount percentage
                $final_price = $product_price - ($product_discount / 100 * $product_price);
                // Assign the final price to the product
                $product->final_price = $final_price;
            } else {
                $product->product_discount = 0;
                $get_category_discount = Category::select('categori_discount')->where('id', $request->category_id)->first();
                if ($get_category_discount->categori_discount == 0) {
                    $product->product_discount = 0;
                    $product->discount_type = '';
                    $product_price = $request->product_price; // Original price of the product
                    $product->final_price = $product_price;
                } else {
                    $product->discount_type = 'category';
                    $product_price = $request->product_price; // Original price of the product
                    $final_price = $product_price - ($get_category_discount->categori_discount / 100 * $product_price);
                    $product->final_price = $final_price;
                }
            }



            $product->product_weight = $request->product_weight;
            $product->description = $request->description;
            $product->wash_care = $request->wash_care;
            $product->search_keywords = $request->search_keywords;
            $product->fabric = $request->fabric;
            $product->fit = $request->fit;
            $product->occassion = $request->occasion;
            $product->sleeve = $request->sleeve;
            $product->pattern = $request->pattern;
            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keywords = $request->meta_keyword;
            //Is Featured condition
            if ($request->is_featured == 1) {
                $product->is_featured = 'yes';
            }
            if ($request->is_featured == 0) {
                $product->is_featured = 'no';
            }
            $product->status = 1;
            $product->save();

            return redirect(route('product.index'))->with(['success_message' => 'Category has been Created successfully']);
        } else {
            return redirect(route('product.index'))->with('error_message', 'Database Error');
        }
    }
    //after product edit .... product store end


    //Product status change
    public function productStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }
    //Product status change end

    // Product Delete
    public function productDestry($id)
    {
        $product = Product::find($id);

        if (!empty($product)) {
            $product->delete();
            return redirect()->back()->with('success_message', 'Category is deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'This category not exist in Database');
        }
    }
    // Product Delete end

    //Product Video Delete
    public function productVideoDelete($id)
    {
        // get category image
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error_message', 'Product not found');
        }

        $productVideo = $product->product_video;

        // get category image path
        $product_Video_Path = public_path('catalogues/product_video/');

        // Delete category image from public catalogues folder if exist
        if ($productVideo && file_exists($product_Video_Path . $productVideo)) {
            unlink($product_Video_Path . $productVideo);
        }

        // Delete category image from category table
        $product->update(['product_video' => null]);

        return redirect()->back()->with('success_message', 'Product Video is deleted Successfully');
    }
    //Product Video Delete end
}
