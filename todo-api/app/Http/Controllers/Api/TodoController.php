<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index(Request $request)
    {

        $dataList = Todo::get();
        return response()->json($dataList);
    }

    public function dataInfoAddOrUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $dataInfo = Todo::find($request->dataId);
            $isNew = false;
    
            if (empty($dataInfo)) {
                $dataInfo = new Todo();
                $isNew = true;
            }
    
            $dataInfo->title = $request->title;
            $dataInfo->body = $request->body;
           
    
            if ($dataInfo->save()) {
                DB::commit();
    
                $responseData = [
                    'errMsgFlag' => false,
                    'msgFlag' => true,
                    'msg' => $isNew ? 'Data inserted successfully.' : 'Data updated successfully.',
                    'errMsg' => null,
                    'task' => $dataInfo,
                ];
    
                return response()->json($responseData, $isNew ? 201 : 200);
            } else {
                DB::rollBack();
    
                return response()->json([
                    'errMsgFlag' => true,
                    'msgFlag' => false,
                    'msg' => null,
                    'errMsg' => $isNew ? 'Data insert failed. Please try again!' : 'Data update failed. Please try again!',
                ], 500);
            }
        } catch (\Exception $err) {
            DB::rollBack();
    
            return response()->json([
                'errMsgFlag' => true,
                'msgFlag' => false,
                'msg' => null,
                'errMsg' => 'Something went wrong. Please try again.',
                'errorDetails' => [
                    'message' => $err->getMessage(),
                    // Remove trace in production!
                ],
            ], 500);
        }
    }
    
    public function toggleComplete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:todos,id',
        ]);
    
        $todo = Todo::findOrFail($request->id);
        $todo->completed = !$todo->completed;
        $todo->save();
    
        return response()->json([
            'msgFlag' => true,
            'msg' => $todo->completed ? 'Task marked as completed.' : 'Task marked as incomplete.',
            'task' => $todo,
        ]);
    }
    
    public function dataInfoDelete(Request $request)
    {
        try {
            DB::beginTransaction();

            $dataInfo = Todo::find($request->dataId);

            if (empty($dataInfo)) {
                $responseData = [
                    'errMsgFlag' => true,
                    'msgFlag' => false,
                    'msg' => null,
                    'errMsg' => 'Data not found!',
                ];
                return response()->json($responseData, 404);
            }



            if ($dataInfo->delete()) {
                DB::commit();
                $responseData = [
                    'errMsgFlag' => false,
                    'msgFlag' => true,
                    'msg' => 'Data deleted successfully.',
                    'errMsg' => null,
                ];
                return response()->json($responseData, 200);
            } else {
                DB::rollBack();
                $responseData = [
                    'errMsgFlag' => true,
                    'msgFlag' => false,
                    'msg' => null,
                    'errMsg' => 'Data deletion failed. Please try again!',
                ];
                return response()->json($responseData, 500);
            }
        } catch (\Exception $err) {
            DB::rollBack();
            $responseData = [
                'errMsgFlag' => true,
                'msgFlag' => false,
                'msg' => null,
                'errMsg' => 'Something went wrong. Please try again.',
                'errorDetails' => [
                    'message' => $err->getMessage(),
                    'trace' => $err->getTraceAsString()
                ],
            ];
            return response()->json($responseData, 500);
        }
    }
}
