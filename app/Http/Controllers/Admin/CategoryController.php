<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::translated()->get();
        return view('Admin.Category.all_categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Category.add_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_name_ar'      => 'required|string|min:3|max:20|unique:section_translations,category_name',
                'category_name_en'      => 'required|string|min:3|max:20|unique:section_translations,category_name',
                'section_id'            => 'required|string',
                'icon_name'             => 'required|image|mimes:jpg,jpeg,png,gif',
                'photo_name'            => 'required|image|mimes:jpg,jpeg,png,gif',
            ]
        );

        if ($validator->fails()) {
            return redirect('admin/categories/create')
                ->withErrors($validator)
                ->withInput();
        }
        $icon_name = $this->saveImage($request->file('icon_name'), 'images/Category', 20, 20);
        $photo_name = $this->saveImage($request->file('photo_name'), 'images/Category', 200, 200);
        $data = [
            'icon_name'           => $icon_name,
            'photo_name'          => $photo_name,
            'section_id'          => $request['section_id'],
            'ar' => [
                'category_name'    => $request['category_name_ar'],
            ],
            'en' => [
                'category_name'    => $request['category_name_en'],
            ],
        ];
        Category::create($data);

        session()->flash('Add', 'تم إضافة الفئة الفرعية بنجاح');
        return redirect('admin/categories');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('Admin.Category.edit_category');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category  = Category::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'category_name_ar'      => 'required|string|min:3|max:20|unique:section_translations,category_name',
                'category_name_en'      => 'required|string|min:3|max:20|unique:section_translations,category_name',
                'section_id'            => 'required|string',
                'icon_name'             => 'required|image|mimes:jpg,jpeg,png,gif',
                'photo_name'            => 'required|image|mimes:jpg,jpeg,png,gif',
            ]
        );

        if ($validator->fails()) {
            return redirect('admin/categories/edit')
                ->withErrors($validator)
                ->withInput();
        }
        // Update The Image
        if ($request->hasFile('icon_name') && $request->hasFile('photo_name')) {
            $icon_destination  =  $category->icon_name;
            $photo_destination =  $category->photo_name;
            if (File::exists($icon_destination) && File::exists($photo_destination)) {
                File::delete($icon_destination);
                File::delete($photo_destination);
            }
            $icon_name = $this->saveImage($request->file('icon_name'), 'images/Category', 20, 20);
            $photo_name = $this->saveImage($request->file('photo_name'), 'images/Category', 200, 200);
        }

        $data = [
            'icon_name'           => $icon_name,
            'photo_name'          => $photo_name,
            'section_id'          => $request['section_id'],
            'ar' => [
                'category_name'    => $request['category_name_ar'],
            ],
            'en' => [
                'category_name'    => $request['category_name_en'],
            ],
        ];
        $category->update($data);

        session()->flash('edit', 'تم تعديل الفئة الفرعية بنجاح');
        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $icon_destination =  $category->icon_name;
        if (File::exists($icon_destination)) {
            File::delete($icon_destination);
        }
        $photo_destination =  $category->photo_name;
        if (File::exists($photo_destination)) {
            File::delete($photo_destination);
        }
        $category->delete();
        session()->flash('delete', 'تم حذف الفئة الفرعية بنجاح');
        return redirect('admin/categories');
    }
}
