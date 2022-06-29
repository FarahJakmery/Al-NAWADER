<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::translated()->get();
        return view('Admin.Advertisement.all_advertisements', compact('advertisements'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::find($id);
        return view('Admin.Advertisement.show_advertisement', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = Advertisement::find($id);
        return view('Admin.Advertisement.edit_advertisements', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advertisement  = Advertisement::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'text_ar'       => 'required|string|min:30|max:255|unique:advertisement_translations,text',
                'text_en'       => 'required|string|min:30|max:255|unique:advertisement_translations,text',
                'user_id'       => 'required|string',
                'section_id'    => 'required|string',
                'category_id'   => 'required|string',
                'image_name'    => 'required|image|mimes:jpg,jpeg,png,gif',
                'price'         => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect('admin/advertisements/edit')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('image_name')) {
            $destination = $advertisement->photo_name;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $image_name = $this->saveImage($request->file('image_name'), 'images/Advertisements', 600, 315);
        }

        $data = [
            'image_name'  => $image_name,
            'price'       => $request['price'],
            'user_id'     => $request['user_id'],
            'section_id'  => $request['section_id'],
            'category_id' => $request['category_id'],
            'ar' => [
                'text'    => $request['text_ar'],
            ],
            'en' => [
                'text'    => $request['text_en'],
            ],
        ];
        $advertisement->update($data);

        session()->flash('edit', 'تم تعديل الإعلان بنجاح');
        return redirect('admin/advertisements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        $destination = $advertisement->image_name;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $advertisement->delete();
        session()->flash('delete', 'تم حذف الإعلان بنجاح');
        return redirect('admin/advertisements');
    }
}
