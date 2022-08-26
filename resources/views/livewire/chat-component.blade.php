

<div class="bg-gray-50 rounded-sm shadow border border-gray-300" x-data="data()">
    <div class="grid grid-cols-3 divide-x divide-gray-300">
        <div class="col-span-1">
            <div class="bg-gray-200 h-16 flex items-center px-4">
                <img class="w-10 h-10 object-cover object-center rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
            </div>
            <div class="h-14 flex items-center bg-gray-100 px-4">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="simple-search" placeholder="Buscar chat o iniciar nuevo"
                        wire:model="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 px-2.5 py-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
            <div class="h-[calc(100vh-14rem)] border-t border-gray-300 overflow-auto">
                {{-- <div class="py-1 px-4 ">
                    <h2 class="text-cyan-500 text-lg mb-4">Contáctos</h2>
                </div> --}}
                @if ($this->chats->count()==0 || $search)
                    <div class="">
                        <ul class="space-y-2">
                            @forelse ($this->contacts as $contact)
                                <li wire:key="chats-{{ $contact->id }}"
                                    wire:click="open_chat_contact({{ $contact }})"
                                    class="cursor-pointer hover:bg-gray-200 ">
                                    <div class="flex flex-row pt-2 px-2 justify-center items-center  ">
                                        <figure class="flex-shrink-0">
                                            <img
                                            src="{{ $contact->user->profile_photo_url }}"
                                            class="h-12 w-12 object-cover rounded-full"
                                            alt="{{ $contact->name }}"
                                            />
                                        </figure>
                                        <div class="flex-1 ml-5 pt-2 border-b border-gray-300">
                                            <p class="text-lg font-semibold">{{ $contact->name }}</p>
                                            <span class="text-gray-500 text-xs">{{ $contact->user->email }}</span>
                                        </div>
                                    </div>
                                    
                                </li>
                            @empty
                                <div class="p-4">
                                    <p class="text-center">
                                        no se encontraron contactos
                                    </p>
                                </div>
                                
                            @endforelse
                        </ul>
                    </div>
                @else
                    <div class="">
                        <ul class="space-y-2">
                            @foreach ($this->chats as $chatls)
                                <li wire:key="chats-{{ $chatls->id }}"
                                    wire:click="open_chat({{ $chatls }})"
                                    class="cursor-pointer hover:bg-sky-100 {{ $chat && $chat->id == $chatls->id ? 'border-b-0 border-l-4 border-blue-400 bg-sky-100':'bg-white' }}">
                                    <div class="flex flex-row pt-2 px-2 justify-center items-center  ">
                                        <figure class="flex-shrink-0 mr-1 sm:mr-2 md:mr-3">
                                            <img
                                            src="{{ $chatls->image }}"
                                            class="h-12 w-12 object-cover rounded-full"
                                            alt="{{ $chatls->name }}"
                                            />
                                        </figure>
                                        <div class="w-[calc(100%-4rem)]  py-2 border-b border-gray-300">
                                            <div class="flex justify-between items-center">
                                                <div class="">
                                                    <p class="text-lg font-semibold">{{ $chatls->name }}</p>
                                                    <p class="text-gray-500 text-sm truncate ">
                                                        {{ $chatls->messages()->get()->last()->body }}                                           
                                                    </p>
                                                </div>
                                                <div class="">
                                                    <p class="text-gray-500 text-xs text-right">
                                                        @if ($chatls->messages()->get()->last()->created_at->format('d-m-y')==now()->format('d-m-y'))
                                                            {{ $chatls->messages()->get()->last()->created_at->format('h:i A') }}
                                                        @else
                                                            {{ $chatls->messages()->get()->last()->created_at->format('d-m-y h:i A') }}
                                                        @endif                                             
                                                    </p>
                                                    <p class="text-right">
                                                        @if($chatls->unread_messages)
                                                            <span class="inline-flex items-center justify-center px-1.5 py-1 mr-2 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full">
                                                                {{ $chatls->unread_messages }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </li>
                            @endforeach

                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-span-2">
            @if ($contactChat || $chat)
                <div class="bg-gray-200 h-16 flex items-center px-4">
                    <figure>
                        @if ($chat)
                            <img class="w-10 h-10 rounded-full object-cover object-center" 
                                src="{{ $chat->image }}" alt="{{ $chat->name }}">
                        @else
                            <img class="w-10 h-10 rounded-full object-cover object-center" 
                                src="{{ $contactChat->user->profile_photo_url }}" alt="{{ $contactChat->name }}">
                        @endif
                        
                    </figure>
                    
                    <div class="ml-4 ">
                        <p class="text-lg text-gray-800 font-semibold">
                            @if ($chat)
                                {{ $chat->name }}
                            @else
                                {{ $contactChat->name }}
                            @endif
                        </p>
                        
                        <span class="text-sky-500 text-xs" x-show="chat_id == typingChatId">
                            Escribiendo...
                        </span>
                        @if ($this->active)
                            <span class="text-sky-500 text-xs" x-show="chat_id != typingChatId" id="online">
                                En linea
                            </span>
                        @else
                            <span class="text-rose-500 text-xs" x-show="chat_id != typingChatId" id="offline">
                                Desconectado
                            </span>
                        @endif
                        
                        
                    </div>
                    
                </div>
                <div class="h-[calc(100vh-14rem)] overflow-auto p-4">
                    @foreach ($this->messages as $message)
                        <div class="flex {{ $message->user_id == auth()->user()->id ? 'justify-end':'justify-start' }}">
                            <div class="rounded px-3 py-2 {{ $message->user_id == auth()->user()->id ? 'bg-cyan-100':'bg-indigo-100' }} mb-2">
                                <p class="text-sm pb-0">
                                    {{ $message->body }}
                                    
                                </p >
                                <p class="{{ $message->user_id == auth()->user()->id ? 'text-right':'text-left' }} text-xs text-gray-600 mt-1 mb-0" style="font-size: 10px">
                                    @if ($message->created_at->format('d-m-y')==now()->format('d-m-y'))
                                        {{ $message->created_at->format('h:i A') }}
                                    @else
                                        {{ $message->created_at->format('d-m-y h:i A') }}
                                    @endif
                                    @if ($message->user_id == auth()->user()->id)
                                        <i class="fas fa-check-double ml-2 text-xs font-semibold {{ $message->is_read ? 'text-teal-500':'text-gray-600' }}"></i>
                                    @endif
                                </p>
                                
                            </div>
                        </div>
                    @endforeach
                    <span id="fnmessages"></span>
                </div>
                {{-- <div class="bg-gray-200 h-10 border-t border-gray-300 px-4 py-2">
                    <form action="">
                        
                    </form>
                </div> --}}
                <div class="bg-gray-200 h-14 border-t border-gray-300 px-4 py-2">
                    <form wire:submit.prevent="sendMessage()">
                        <div class="relative flex">
                            <span class="absolute inset-y-0 flex items-center">
                               <button type="button" class="inline-flex items-center justify-center rounded-full h-8 w-8 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                  </svg>
                               </button>
                            </span>
                            <input type="text" wire:model="messagetext"
                                placeholder="Escribe mensaje!" class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 sm:pr-36 bg-white rounded-md py-2">
                            <div class="absolute right-0 items-center inset-y-0 hidden sm:flex mx-2">
                               <button type="button" class="inline-flex items-center justify-center rounded-full h-8 w-8 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                  </svg>
                               </button>
                               <button type="button" class="inline-flex items-center justify-center rounded-full h-8 w-8 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                  </svg>
                               </button>
                               <button type="button" id="emojipick" onclick="triggerEmoji()"
                                    class="inline-flex items-center justify-center rounded-full h-8 w-8 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                  </svg>
                               </button>
                               <button type="submit" 
                                    class="inline-flex items-center justify-center rounded-lg px-1 py-1 transition duration-500 ease-in-out  focus:outline-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 ml-2 transform rotate-90 text-blue-500">
                                     <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                  </svg>
                               </button>
                            </div>
                         </div>
                    </form>
                 </div>
            @else
                <div class="w-full h-full flex justify-center items-center">
                    <div class="">
                        <img src="{{ asset('images/chat.png') }}" class="h-72 w-72 object-cover object-cente"  alt="chat.png">
                        <h1 class="text-center text-gray-500 font-semibold text-4xl">
                            ChatWeb para escritorio
                        </h1>
                    </div>
                    
                </div>
            @endif
        </div>
    </div>
    @push('js')
        <script>
            livewire.on('scrollintoview',function(){
                document.getElementById('fnmessages').scrollIntoView(true);
            });
            function data(){
                return {
                    chat_id:@entangle('chat_id'),
                    typingChatId:null,
                    init(){
                        Echo.private('App.Models.User.' + {{ auth()->user()->id }})
                            .notification((notification) => {
                                if(notification.type=='App\\Notifications\\UserTyping'){
                                    this.typingChatId=notification.chat_id;
                                    setTimeout(() => {
                                        this.typingChatId=null;
                                    }, 2000);
                                }
                        });
                    }
                }
            }
        </script>
    @endpush
</div>
