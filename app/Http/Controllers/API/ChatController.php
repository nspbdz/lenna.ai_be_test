<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\Chat\ChatRepository;

class ChatController extends Controller
{
    private $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function chat(Request $request)
    {
        // return 1;
        return $this->chatRepository->chat($request);

    }

    public function index(Request $request)
    {
        // return 1;
        return $this->chatRepository->index($request);
    }

    public function byId(Request $request)
    {
        // return $request->id;
        return $this->chatRepository->byId($request);
    }
}
