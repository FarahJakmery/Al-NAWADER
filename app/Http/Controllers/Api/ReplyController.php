<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    use ApiResponseTrait;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addReply(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reply_text'       => 'required|string|max:255',
                'user_id'          => 'required|integer',
                'advertisement_id' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $data = [
            'reply_text'       => $request['reply_text'],
            'user_id'          => $request['user_id'],
            'advertisement_id' => $request['advertisement_id'],
        ];
        $reply = Reply::create($data);

        if ($reply) {
            return $this->apiResponse($reply, 'Reply Was Added Successfully', 200);
        }
        return $this->apiResponse($reply, 'Reply was not Added Successfully', 400);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function updateReply(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reply_text'       => 'required|string|max:255',
                'user_id'          => 'required|integer',
                'advertisement_id' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $reply  = Reply::find($id);

        $data = [
            'reply_text'       => $request['reply_text'],
            'user_id'          => $request['user_id'],
            'advertisement_id' => $request['advertisement_id'],
        ];
        $reply->update($data);
        if ($reply) {
            return $this->apiResponse($reply, 'Reply Updated Successfully', 200);
        }
        return $this->apiResponse($reply, 'Reply was not Updated Successfully', 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function removeReply($id)
    {
        $reply  = Reply::find($id);
        $reply->delete();
        if ($reply) {
            return $this->apiResponse(null, 'Reply Was Deleted Successfully', 200);
        }
        return $this->apiResponse(null, 'Reply was not Deleted Successfully', 400);
    }
}
