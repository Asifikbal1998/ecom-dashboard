<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsPage;
use App\Http\Controllers\Controller;
use App\Models\SubadminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CmsPageController extends Controller
{
    /**
     * Display a listing of the CMS pages.
     */
    public function index()
    {
        // Set the current page in session
        Session::put('page', 'cmsPages');
        
        // Retrieve all CMS pages from the database
        $cmsPages = CmsPage::all();

        // Determine admin or subadmin permissions for CMS pages
        $cmspageModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->count();
        $pageModule = array();
        
        // Grant full access if the user is an admin
        if (Auth::guard('admin')->user()->type == 'admin') {
            $pageModule['view_access'] = 1;
            $pageModule['edit_access'] = 1;
            $pageModule['full_access'] = 1;
        } elseif ($cmspageModuleCount == 0) {
            // Redirect with an error message if the subadmin has no access
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_message', $message);
        } else {
            // Retrieve specific permissions for the subadmin
            $pageModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->first()->toArray();
        }

        // Render the CMS pages view with the retrieved data
        return view('admin.cms_page.cms_pages')->with(['cmsPages' => $cmsPages, 'pageModule' => $pageModule]);
    }

    /**
     * Show the form for creating a new CMS page.
     */
    public function create()
    {
        // Render the form for creating a new CMS page
        return view('admin.cms_page.cms_page_create');
    }

    /**
     * Store a newly created CMS page in storage.
     */
    public function store(Request $request)
    {
        // Handle the POST request for storing a new CMS page
        if ($request->isMethod('post')) {

            // Define validation rules and custom error messages
            $rule = [
                'page_title' => 'required|max:255',
                'description' => 'required',
                'page_url' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
            ];

            $customMessage = [
                'email.page_title' => 'Page Title is required',
                'email.max' => 'Page Title character limit is less than 255',
                'password.page_url' => 'Page URL is required',
                'password.meta_title' => 'Meta Title is required',
                'password.meta_description' => 'Meta Description is required',
                'password.meta_keywords' => 'Meta Keywords are required',
            ];

            // Validate the request data
            $this->validate($request, $rule, $customMessage);

            // Create a new CMS page and save to the database
            $cmsPages = new CmsPage();
            $cmsPages->title = $request->page_title;
            $cmsPages->description = $request->description;
            $cmsPages->url = $request->page_url;
            $cmsPages->meta_title = $request->meta_title;
            $cmsPages->meta_description = $request->meta_description;
            $cmsPages->mata_keywords = $request->meta_keywords;
            $cmsPages->save();

            // Redirect with a success message
            return redirect(route('cmsPages.index'))->with('success_message', 'Page Added Successfully');
        }
    }

    /**
     * Display the specified CMS page.
     */
    public function show(string $id)
    {
        // Retrieve the CMS page by ID
        $cmsPage = CmsPage::find($id);
        
        // Check if the CMS page exists and render the update view
        if (!empty($cmsPage)) {
            return view('admin.cms_page.cms_page_update')->with('cmsPage', $cmsPage);
        }
    }

    /**
     * Show the form for editing the specified CMS page.
     */
    public function edit(string $id, Request $request)
    {
        // Handle the POST request for updating an existing CMS page
        if ($request->isMethod('post')) {

            // Define validation rules and custom error messages
            $rule = [
                'page_title' => 'required|max:255',
                'description' => 'required',
                'page_url' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
            ];

            $customMessage = [
                'email.page_title' => 'Page Title is required',
                'email.max' => 'Page Title character limit is less than 255',
                'password.page_url' => 'Page URL is required',
                'password.meta_title' => 'Meta Title is required',
                'password.meta_description' => 'Meta Description is required',
                'password.meta_keywords' => 'Meta Keywords are required',
            ];

            // Validate the request data
            $this->validate($request, $rule, $customMessage);

            // Retrieve the existing CMS page by ID and update its attributes
            $cmsPage = CmsPage::find($id);
            $cmsPage->title = $request->page_title;
            $cmsPage->description = $request->description;
            $cmsPage->url = $request->page_url;
            $cmsPage->meta_title = $request->meta_title;
            $cmsPage->meta_description = $request->meta_description;
            $cmsPage->mata_keywords = $request->meta_keywords;
            $cmsPage->save();

            // Redirect with a success message
            return redirect(route('cmsPages.index'))->with('success_message', 'Page Details updated Successfully');
        }
    }

    /**
     * Update the status of the specified CMS page via AJAX.
     */
    public function update(Request $request)
    {
        // Handle the AJAX request for updating the CMS page status
        if ($request->ajax()) {
            $data = $request->all();
            
            // Toggle the status between Active and Inactive
            $status = ($data['status'] == 'Active') ? 0 : 1;
            
            // Update the status in the database
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            
            // Return the updated status as JSON response
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    /**
     * Remove the specified CMS page from storage.
     */
    public function destroy(string $id)
    {
        // Retrieve the CMS page by ID
        $cmsPage = CmsPage::find($id);
        
        // Check if the CMS page exists
        if (!empty($cmsPage)) {
            // Delete the CMS page and redirect with a success message
            $cmsPage->delete();
            return redirect()->back()->with('success_message', 'Page is deleted Successfully');
        } else {
            // Redirect with an error message if the CMS page does not exist
            return redirect()->back()->with('error_message', 'This page does not exist in the database');
        }
    }
}
?>