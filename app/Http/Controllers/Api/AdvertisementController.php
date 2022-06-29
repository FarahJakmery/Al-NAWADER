<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SaveImageTrait;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    use ApiResponseTrait, SaveImageTrait;

    public function allAdvertisements()
    {
        $advertisements = Advertisement::with('replies')->paginate(10);
        return $this->apiResponse($advertisements, 'All Advertisements', 200);
    }

    public function storeAdvertisement(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'text_ar'       => 'required|string|min:30|max:255|unique:advertisement_translations,text',
                'text_en'       => 'required|string|min:30|max:255|unique:advertisement_translations,text',
                'user_id'       => 'required|string',
                'section_id'    => 'required|string',
                'category_id'   => 'string',
                'image_name'    => 'required|image|mimes:jpg,jpeg,png,gif',
                'price'         => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $image_name = $this->saveImage($request->file('image_name'), 'images/Advertisements', 600, 315);

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
        $advertisement = Advertisement::create($data);

        if ($advertisement) {
            return $this->apiResponse($advertisement, 'Advertisement Added Successfully', 200);
        }
        return $this->apiResponse($advertisement, 'Advertisement was not Added Successfully', 400);
    }

    public function showAdvertisement($advertisement_id)
    {
        $advertisement = Advertisement::with('replies')->find($advertisement_id);
        if ($advertisement) {
            return $this->apiResponse($advertisement, 'This Is The Required Advertisement', 200);
        }
        return $this->apiResponse($advertisement, 'The Advertisement Not Found', 401);
    }

    public function updateAdvertisement(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'text_ar'       => 'required|string|min:30|max:255|unique:advertisement_translations,text,' . $id,
                'text_en'       => 'required|string|min:30|max:255|unique:advertisement_translations,text,' . $id,
                'user_id'       => 'required|string',
                'section_id'    => 'required|string',
                'category_id'   => 'required|string',
                'image_name'    => 'required|image|mimes:jpg,jpeg,png,gif',
                'price'         => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $advertisement  = Advertisement::find($id);
        if ($request->hasFile('image_name')) {
            $destination = $advertisement->image_name;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $photo = $request->file('image_name');
            $image_name = $this->saveImage($photo, 'images/Advertisements', 600, 315);
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
        if ($advertisement) {
            return $this->apiResponse($advertisement, 'Advertisement Updated Successfully', 200);
        }
        return $this->apiResponse($advertisement, 'Advertisement was not Updated Successfully', 400);
    }

    public function removeAdvertisements($id)
    {
        $advertisement = Advertisement::find($id);
        $destination = $advertisement->image_name;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $advertisement->delete();
        if ($advertisement) {
            return $this->apiResponse(null, 'Advertisement Deleted Successfully', 200);
        }
        return $this->apiResponse(null, 'Advertisement was not Deleted Successfully', 400);
    }

    public function myAdvertisement(Request $request)
    {
        $my_advertisements = Advertisement::where('user_id', '=', $request->user_id)->get();
        if (count($my_advertisements) == null) {
            return $this->apiResponse($my_advertisements, 'No ads for you yet', 200);
        }
        return $this->apiResponse($my_advertisements, 'These Are Your Advertisements', 200);
    }
}
