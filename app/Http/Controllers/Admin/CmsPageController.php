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
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'cmsPages');
        $cmsPages = CmsPage::all();

        //set admin/subadmin role/permession for cms page
        $cmspageModuleCount = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->count();
        $pageModule = array();
        if (Auth::guard('admin')->user()->type == 'admin') {
            $pageModule['view_access'] = 1;
            $pageModule['edit_access'] = 1;
            $pageModule['full_access'] = 1;
        } elseif ($cmspageModuleCount == 0) {
            $message = 'This feature is restricted for you!';
            return redirect(route('admin.dashboard'))->with('error_meaasge', $message);
        } else {
            $pageModule = SubadminRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->first()->toArray();
        }
        
        return view('admin.cms_pages')->with(['cmsPages' => $cmsPages, 'pageModule' => $pageModule]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cms_page_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {


            $rule = [
                'page_title' => 'required|max:255',
                'description' => 'required',
                'page_url' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
            ];

            $customMessage = [
                'email.page_title' => 'Page Title Is required',
                'email.max' => 'Page Title char limit is less than 255',
                'password.page_url' => 'Page url is required',
                'password.meta_title' => 'Page Meta title is required',
                'password.meta_description' => 'Page Meta description is required',
                'password.meta_keywords' => 'Page Meta Key words is required',
            ];

            $this->validate($request, $rule, $customMessage);

            $cmsPages = new CmsPage();
            $cmsPages->title = $request->page_title;
            $cmsPages->description = $request->description;
            $cmsPages->url = $request->page_url;
            $cmsPages->meta_title = $request->meta_title;
            $cmsPages->meta_description = $request->meta_description;
            $cmsPages->mata_keywords = $request->meta_keywords;
            $cmsPages->save();

            return redirect('admin/cms-pages')->with('success_message', 'Page Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cmsPage = CmsPage::find($id);
        if (!empty($cmsPage)) {
            return view('admin.cms_page_update')->with('cmsPage', $cmsPage);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        if ($request->isMethod('post')) {

            $rule = [
                'page_title' => 'required|max:255',
                'description' => 'required',
                'page_url' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
            ];

            $customMessage = [
                'email.page_title' => 'Page Title Is required',
                'email.max' => 'Page Title char limit is less than 255',
                'password.page_url' => 'Page url is required',
                'password.meta_title' => 'Page Meta title is required',
                'password.meta_description' => 'Page Meta description is required',
                'password.meta_keywords' => 'Page Meta Key words is required',
            ];

            $this->validate($request, $rule, $customMessage);

            $cmsPage = CmsPage::find($id);

            $cmsPage->title = $request->page_title;
            $cmsPage->description = $request->description;
            $cmsPage->url = $request->page_url;
            $cmsPage->meta_title = $request->meta_title;
            $cmsPage->meta_description = $request->meta_description;
            $cmsPage->mata_keywords = $request->meta_keywords;
            $cmsPage->save();

            return redirect('admin/cms-pages')->with('success_message', 'Page Details updated Successfully');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            CmsPage::where('id', $data['page_id'])->update(['ststus' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cmsPage = CmsPage::find($id);
        if (!empty($cmsPage)) {
            $cmsPage->delete();
            return redirect()->back()->with('success_message', 'Page is deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'This page not exist in Database');
        }
    }
}
