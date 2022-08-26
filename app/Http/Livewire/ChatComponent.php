<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\Message;
use App\Notifications\NewMessageNotify;
use App\Notifications\ReadMessage;
use App\Notifications\UserTyping;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ChatComponent extends Component
{
    public $search;
    public $contactChat,$chat,$chat_id;
    public $messagetext;
    public $users;

    public function mount(){
        $this->users=collect();
    }
    //listeners---oyentes
    public function getListeners(){
        $user_id=auth()->user()->id;
        //$this->emit('hola');
        return [
            "echo-notification:App.Models.User.{$user_id},notification"=>'render',
            "echo-presence:chat.1,here"=>'chatHere',
            "echo-presence:chat.1,joining"=>'chatJoining',
            "echo-presence:chat.1,leaving"=>'chatLeaving',
        ];
        
    }
    //propiedda computada
    public function getContactsProperty(){
        return Contact::where('user_id',auth()->user()->id)
                ->when($this->search,function($query){
                    $query->where(function($query){
                        $query->where('name','LIKE','%'.$this->search.'%')
                            ->orWhereHas('user',function($query){
                                $query->where('email','LIKE','%'.$this->search.'%');
                        });
                    });
                })->get() ?? [];
    }
    public function getMessagesProperty(){
        return $this->chat ? Message::where('chat_id',$this->chat->id)->get() : [];
        //return $this->chat ? $this->chat->messages()->get() : [];
    }
    public function getChatsProperty(){
        return auth()->user()->chats()->get()->sortByDesc('last_message_at');
    }
    public function getUsersNotifyProperty(){
        return $this->chat ? $this->chat->users->where('id','!=',auth()->user()->id) :collect();
    }
    public function getUserIdProperty(){
        return auth()->user()->id;
    }
    public function getActiveProperty(){
        if($this->users_notify->first()){
            return $this->users->contains($this->users_notify->first()->id);
        }
        //return $this->users->contains($this->users_notify->first()->id);
    }
    //ciclo de vida
    public function updatedMessagetext($value){
        if($value && $this->chat){
            Notification::send($this->users_notify,new UserTyping($this->chat->id));
        }
    }
    //metodos
    public function open_chat_contact(Contact $contact){
        $chat=auth()->user()->chats()
            ->whereHas('users',function($query) use ($contact){
                $query->where('user_id',$contact->contact_id);
            })->has('users',2)
            ->first();
        if($chat){
            $this->chat=$chat;
            $this->chat_id=$chat->id;
            $this->reset('messagetext','contactChat','search');
        }else{
            $this->contactChat=$contact;
            $this->reset('messagetext','chat','search');
        }
    }
    public function open_chat(Chat $chat){
        $this->chat=$chat;
        $this->chat_id=$chat->id;
        /* $chat->messages()->where('user_id','!=',auth()->user()->id)->where('is_read',false)->update([
            'is_read'=>true
        ]);
        Notification::send($this->users_notify,new ReadMessage()); */
        $this->reset('messagetext','contactChat');
    }
    public function sendMessage(){
        $this->validate([
            'messagetext'=>'required'
        ]);
        if(!$this->chat){
            $this->chat=Chat::create();
            $this->chat_id=$this->chat->id;
            $this->chat->users()->sync([
                auth()->user()->id,
                $this->contactChat->contact_id
            ]);
            
        }
        $this->chat->messages()->create([
            'body'=>$this->messagetext,
            'user_id'=>auth()->user()->id
        ]);
        
        Notification::send($this->users_notify,new NewMessageNotify());

        $this->reset('messagetext','contactChat');
    }
    public function chatHere($users){//recupera usuarios conectados
        $this->users=collect($users)->pluck('id');
    }
    public function chatJoining($user){//cuando se conecta un nuevo usuario
        $this->users->push($user['id']);
    }
    public function chatLeaving($user){//cuando se desconecta un usuario
        $this->users=$this->users->filter(function($id) use($user){
            return $id != $user['id'];
        });
    }
    public function render()
    {
        if($this->chat){
            if($this->chat->unread_messages>0){
                Notification::send($this->users_notify,new ReadMessage());
            }
            $this->chat->messages()->where('user_id','!=',auth()->user()->id)->where('is_read',false)->update([
                'is_read'=>true
            ]);
            //Notification::send($this->users_notify,new ReadMessage());
            $this->emit('scrollintoview');
        }
        return view('livewire.chat-component')->layout('layouts.chat');
    }
}
