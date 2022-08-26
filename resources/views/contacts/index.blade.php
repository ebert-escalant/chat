<x-app-layout>
    <div class="container-fluid">
        <div class="flex justify-end mb-4">
            <a class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm py-2 px-4 border-b-4 border-blue-700 hover:border-blue-800 rounded uppercase inline-flex items-center"
                href="{{ route('contacts.create') }}">
                <i class="fa fa-plus text-white mr-2 text-lg"></i>
                Nuevo Contacto
            </a>
        </div>
        @if ($contacts->count())
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Nombre
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Email
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $contact->name }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $contact->user->email }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-end space-x-4">
                                        <a href="{{ route('contacts.edit',$contact) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500">
                                            <i class="fas fa-edit text-lg text-emerald-600"></i>
                                        </a>
                                        {{-- <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 ">
                                            <i class="fas fa-trash-alt text-lg text-red-600"></i>
                                        </a> --}}
                                        <form action="{{ route('contacts.destroy',$contact) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="font-medium text-blue-600 dark:text-blue-500">
                                                <i class="fas fa-trash-alt text-lg text-red-600"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-alert-one type="info">
                Usted no tiene contactos
            </x-alert-one>
        @endif


    </div>
</x-app-layout>
