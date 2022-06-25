<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Traits\SaveImageTrait;
use Illuminate\Support\Facades\File;

class SectionController extends Controller
{
    use SaveImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::translated()->get();
        return view('Admin.Section.section', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Section.add_section');
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
                'section_name_ar'       => 'required|string|min:3|max:20|unique:section_translations,section_name',
                'section_name_en'       => 'required|string|min:3|max:20|unique:section_translations,section_name',
                'icon_name'             => 'required|image|mimes:jpg,jpeg,png,gif',
                'photo_name'            => 'required|image|mimes:jpg,jpeg,png,gif',
            ]
        );

        if ($validator->fails()) {
            return redirect('admin/sections/create')
                ->withErrors($validator)
                ->withInput();
        }
        $icon_name = $this->saveImage($request->file('icon_name'), 'images/Section', 20, 20);
        $photo_name = $this->saveImage($request->file('photo_name'), 'images/Section', 200, 200);
        $data = [
            'icon_name'           => $icon_name,
            'photo_name'          => $photo_name,
            'ar' => [
                'section_name'    => $request['section_name_ar'],
            ],
            'en' => [
                'section_name'    => $request['section_name_en'],
            ],
        ];
        Section::create($data);

        session()->flash('Add', 'تم إضافة الفئة الرئيسية بنجاح');
        return redirect('admin/sections');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return view('Admin.Section.edit_section');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'section_name_ar'       => 'required|string|min:3|max:20|unique:section_translations,section_name',
                'section_name_en'       => 'required|string|min:3|max:20|unique:section_translations,section_name',
                'icon_name'             => 'required|image|mimes:jpg,jpeg,png,gif',
                'photo_name'            => 'required|image|mimes:jpg,jpeg,png,gif',
            ]
        );

        if ($validator->fails()) {
            return redirect('admin/sections/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Update The Image
        if ($request->hasFile('icon_name') && $request->hasFile('photo_name')) {
            $icon_destination  =  $section->icon_name;
            $photo_destination =  $section->photo_name;
            if (File::exists($icon_destination) && File::exists($photo_destination)) {
                File::delete($icon_destination);
                File::delete($photo_destination);
            }
            $icon_name = $this->saveImage($request->file('icon_name'), 'images/Section', 20, 20);
            $photo_name = $this->saveImage($request->file('photo_name'), 'images/Section', 200, 200);
        }

        $data = [
            'icon_name'           => $icon_name,
            'photo_name'          => $photo_name,
            'ar' => [
                'section_name'    => $request['section_name_ar'],
            ],
            'en' => [
                'section_name'    => $request['section_name_en'],
            ],
        ];
        $section->update($data);

        session()->flash('Add', 'تم تعديل الفئة الرئيسية بنجاح');
        return redirect('admin/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);
        $icon_destination =  $section->icon_name;
        if (File::exists($icon_destination)) {
            File::delete($icon_destination);
        }
        $photo_destination =  $section->photo_name;
        if (File::exists($photo_destination)) {
            File::delete($photo_destination);
        }
        $section->delete();
        session()->flash('delete', 'تم حذف الفئة الرئيسية بنجاح');
        return redirect('admin/sections');
    }
}
