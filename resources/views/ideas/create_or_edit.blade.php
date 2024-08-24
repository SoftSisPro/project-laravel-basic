<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action=" {{ empty($idea) ? route('idea.store') : route('idea.update', $idea) }}">
                        @csrf

                        @if(empty($idea))
                            @method('post')
                        @else
                            @method('put')
                        @endif

                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="title" :value="old('title', empty($idea) ? '' : $idea->title)" placeholder="Ingresa título" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />

                        <textarea
                            name="description"
                            class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >{{ old('description', empty($idea) ? 'Mi Descripción......' : $idea->description) }}
                        </textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />

                        <div class="mt-4 space-x-8">
                            <x-primary-button>
                                <i class="fa fa-fw fa-download"></i>
                                {{ empty($idea) ? 'Guardar': 'Actualizar' }}
                            </x-primary-button>
                            <a href="{{ route('idea.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fa fa-fw fa-ban" ></i> Cancelar
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
