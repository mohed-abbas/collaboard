<div class="bg-tranparent rounded-lg shadow  p-4">
    <h3 class="text-lg font-semibold mb-2">My Projects</h3>
    <ul class="divide-y divide-gray-200">
        @forelse($projects as $project)
        <li class="relative flex justify-between items-center py-2" x-data="{ open: false }">
            <!-- Project Name -->
            <a href="{{ route('project.board', $project->id) }}">
                {{ $project->name }}
            </a>

            <!-- Dropdown Trigger & Menu -->
            <div class="relative">
                <!-- Ellipsis Button -->
                <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200 focus:outline-none">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <ul x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-20">
                    <li>
                        <button wire:click="deleteProject({{ $project->id }})" @click="open = false"
                            onclick="confirm('Delete this project?') || event.stopImmediatePropagation()"
                            class="block w-full text-left px-4 text-black py-2 hover:bg-gray-100">
                            Delete
                        </button>
                    </li>
                    <li>
                        <a href="{{ route('project.settings', $project->id) }}"
                            class="block w-full text-left text-black px-4 py-2 hover:bg-gray-100">
                            Settings
                        </a>
                </ul>
            </div>
        </li>
        @empty
        <li class="py-2 text-gray-500">
            You’re not part of any projects yet.
        </li>
        @endforelse

        {{-- Create Button --}}
        <button wire:click="openCreateModal"
            class="mb-4 w-full px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
            + Create Project
        </button>
    </ul>

    {{-- Project Modal --}}
    @include('livewire.project-modal')
</div>