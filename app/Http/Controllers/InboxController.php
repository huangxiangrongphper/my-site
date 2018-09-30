<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use App\Repositories\MessageRepository;

/**
 * Class InboxController
 *
 * @package App\Http\Controllers
 */
class InboxController extends Controller
{
    /**
     * @var \App\Repositories\MessageRepository
     */
    protected $messageRepository;
    /**
     * InboxController constructor.
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $messages = $this->messageRepository->getAllMessages();

        return view('inbox.index',['messages' => $messages->groupBy('dialog_id') ]);
    }

    /**
     * @param $dialogId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($dialogId)
    {
        $messages = $this->messageRepository->getDialogMessagesBy($dialogId);

        $messages->markAsRead();

        return view('inbox.show',compact('messages','dialogId'));
    }

    /**
     * @param $dialogId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($dialogId)
    {
        $message   = $this->messageRepository->getSingleMessageBy($dialogId);

        $toUserId  = $message->from_user_id === user()->id ? $message->to_user_id : $message->from_user_id;
       $newMessage =  $this->messageRepository->create([
            'from_user_id' => user()->id,
            'to_user_id'   => $toUserId,
            'body'         => request('body'),
            'dialog_id'    => $dialogId
        ]);

       $newMessage->toUser->notify(new NewMessageNotification($newMessage));

        return back();
    }
}
