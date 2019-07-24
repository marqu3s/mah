<?php

namespace App\Http\Controllers\API;

use App\Models\UserSetting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserSettingController extends BaseController
{
    public function show(Request $request, $userId)
    {
        if ((int) $userId === auth()->user()->id) {
            try {
                $userSetting = UserSetting::where([
                    'user_id' => auth()->user()->id,
                ])->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $userSetting = new UserSetting();
                $userSetting->user_id = (int) $userId;
                $userSetting->save();
            }

            return $this->sendResponse($userSetting->toArray(), 'User settings loaded.');
        }

        return $this->sendError("You can not set other user's settings.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $user_id
     *
     * @return Response
     */
    public function update(Request $request, $user_id)
    {
        if ((int) $user_id === auth()->user()->id) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'language' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $userSetting = UserSetting::updateOrCreate([
                'user_id' => auth()->user()->id,
            ]);

            $userSetting->language = $input['language'];
            $userSetting->save();

            return $this->sendResponse($userSetting->toArray(), 'User settings updated successfully.');
        }

        return $this->sendError("You can not set other user's settings.");
    }
}
