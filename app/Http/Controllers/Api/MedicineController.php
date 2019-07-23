<?php

namespace App\Http\Controllers\Api;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return string
     */
    public function index(Request $request)
    {
        $medicines = Medicine::where('user_id', auth()->user()->id)
            ->get();

        $data = [
            'medicines' => $medicines->toArray()
        ];

        return $this->sendResponse($data, 'Medicines loaded.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return string
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'format' => 'required',
            'exp_year' => 'required',
            'exp_month' => 'required',
            'available_qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (($id = $request->input('id', null)) !== null) {
            $model = Medicine::where('user_id', auth()->user()->id)
                ->Where('id', $id)
                ->first();
        } else {
            $model = new Medicine();
            $model->user_id = auth()->user()->id;
        }

        $model->name = $request->input('name');
        $model->format = $request->input('format');
        $model->exp_year = $request->input('exp_year');
        $model->exp_month = $request->input('exp_month');
        $model->available_qty = $request->input('available_qty');
        $model->save();

        return $this->sendResponse($model->toArray(), 'Saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return string
     */
    public function show($id)
    {
        $model = Medicine::where('user_id', auth()->user()->id)
            ->Where('id', $id)
            ->first();

        return $this->sendResponse($model->toArray(), 'Loaded successfully.');
    }

    /**
     * Delete the specified resource.
     *
     * @param int $id
     *
     * @return string
     */
    public function destroy($id)
    {
        $result = Medicine::where('user_id', auth()->user()->id)
            ->Where('id', $id)
            ->first()
            ->delete();

        return $this->sendResponse($result, 'Deleted successfully.');
    }
}
