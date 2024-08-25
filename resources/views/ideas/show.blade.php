<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl pb-3">{{ $idea->title }}</h1>
                    <p>{{ $idea->description }}</p>
                    <form method="POST" action="{{ route('idea.voteLikes',$idea) }}">
                        @csrf
                        @method('put')
                        <div class="mt-4 space-x-8">
                            @if(auth()->user()->hasLikedIdea($idea->id))
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fa fa-fw fa-thumbs-down"></i>
                                    <span class="ml-3">Ya No me Gusta</span>
                                </button>
                            @else
                                <x-primary-button>
                                    <i class="fa fa-fw fa-thumbs-up"></i>
                                    <span class="ml-3"> Me Gusta</span>
                                </x-primary-button>
                            @endif
                            <a href="{{ route('idea.index') }}" class="dark:text-gray-100">Regresear</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
