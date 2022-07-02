<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SaveImageTrait;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{
    use ApiResponseTrait, SaveImageTrait;

    public function commissionRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id'                  => 'required|integer',
                'user_name'                => 'required|string|max:255|unique:users,user_name',
                'email'                    => 'required|string',
                'mobile_number'            => 'required|string',
                'advertisement_number'     => 'required|string',
                'advertisement_price'      => 'required|string',
                'advertisement_commission' => 'required',
                'date'                     => 'required',
                'receipt_photo'            => 'required|image|mimes:jpg,jpeg,png,gif',
            ]
        );

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $image_name = $this->saveImage($request->file('receipt_photo'), 'images/Commission_Requests', 600, 315);
        $data = [
            'user_id'                  => $request['user_id'],
            'user_name'                => $request['user_name'],
            'email'                    => $request['email'],
            'mobile_number'            => $request['mobile_number'],
            'advertisement_number'     => $request['advertisement_number'],
            'advertisement_price'      => $request['advertisement_price'],
            'advertisement_commission' => $request['advertisement_commission'],
            'date'                     => $request['date'],
            'receipt_photo'            => $image_name,
        ];
        $commission = Commission::create($data);

        if ($commission) {
            return $this->apiResponse($commission, 'Commission request sent successfully', 200);
        }
        return $this->apiResponse($commission, 'Commission request was not sent successfully', 400);
    }

    public function allCommissionRequest($id)
    {
        $commissionRequests = Commission::where('user_id', '=', $id)->paginate(10);
        return $this->apiResponse($commissionRequests, 'These are all commission requests for this user', 200);
    }
}
