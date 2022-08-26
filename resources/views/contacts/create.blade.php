<x-app-layout>
    <div class="container-fluid">
        <div class="bg-white shadow-lg rounded p-6">
            <form action="{{ route('contacts.store') }}" method="post" autocomplete="off">
                @csrf
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-4">
                    <label for="name" class="text-sm mb-1 text-gray-700 dark:text-gray-200">Nombre de contacto</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="ingrese nombre del contacto"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
                <div class="mb-4">
                    <label for="email" class="text-sm mb-1 text-gray-700 dark:text-gray-200">Correo electronico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="ingrese el correo electronico"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
                <div class="flex justify-end">
                    <button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-emerald-700 rounded-md hover:bg-emerald-800 focus:outline-none focus:bg-emerald-800 uppercase">
                        Crear contacto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>