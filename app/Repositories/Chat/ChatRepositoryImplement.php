<?php

namespace App\Repositories\Chat;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use DB;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
class ChatRepositoryImplement extends Eloquent implements ChatRepository
{
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Chat $model)
    {
        $this->model = $model;
    }


    public function chat($request)
    {

        try {

            DB::beginTransaction();

            $input = new $this->model();
            $input->sender = Auth::user()->id;
            $input->receiver = $request->receiver;
            $input->message = $request->message;
            $input->save();


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return BaseController::error(NULL, $e->getMessage(), 400);
        }
        return BaseController::success($input, "Sukses menambah data", 200);
    }

    public function index(){
        try {
            $query= Chat::with('receiver')->where('sender', '=', Auth::user()->id)->latest('created_at')->get();
        } catch (\Throwable $th) {
            //throw $th;
            return BaseController::error(NULL, $th->getMessage(), 400);

        }
        return BaseController::success($query, "Sukses update data", 200);

    }
    public function byId($request){
        // return Auth::user()->id;
        // return $request->id;

        try {
            $query = DB::table('chats')
            ->whereIn('sender', [Auth::user()->id,$request->id])
            ->whereIn('receiver', [Auth::user()->id,$request->id])
            ->orderBy('created_at')
            ->get();


        } catch (\Throwable $th) {
            //throw $th;
            return BaseController::error(NULL, $th->getMessage(), 400);

        }
        return BaseController::success($query, "Sukses update data", 200);

    }


}
