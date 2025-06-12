<div>
    <h1 class="text-2xl font-bold mb-4">Project Settings</h1>
    <p class="text-gray-600 mb-6">Manage your project settings below.</p>
    <div class="bg-white shadow rounded-lg p-6">
        <form wire:submit.prevent="saveSettings">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" id="name" wire:model="projectName"
                    class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter project name">
                @error('projectName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Project Description</label>
                <textarea id="description" wire:model="projectDescription"
                    class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter project description"></textarea>
                @error('projectDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring">
                Save Settings
            </button>
        </form>
        <hr class="my-6">

        <!-- Members -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-4">Project Members</h2>
            <div class="mt-4 relative">
                <input type="text" wire:model.live="searchMember" class="p-2 border border-gray-300 rounded-md w-full"
                    placeholder="Search users by name or email to add to project" wire:focus="showSearchResults = true">

                @error('newMemberEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Search Results Dropdown -->
                @if($showSearchResults && !empty($searchMember) && count($searchResults) > 0)
                <div
                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                    @foreach($searchResults as $user)
                    <div
                        class="flex items-center justify-between p-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </div>
                        <button wire:click="addMemberToProject({{ $user->id }})"
                            class="ml-3 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring">
                            Add
                        </button>
                    </div>
                    @endforeach
                </div>
                @elseif($showSearchResults && !empty($searchMember) && count($searchResults) === 0)
                <div class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                    <div class="text-gray-500 text-sm">No users found matching "{{ $searchMember }}"</div>
                </div>
                @endif
            </div>

            <!-- Current Members List -->
            <div class="mt-6">
                <h3 class="text-md font-medium mb-3">Current Members</h3>
                <ul class="divide-y divide-gray-200 border border-gray-200 rounded-md">
                    @forelse($members as $member)
                    <li class="flex justify-between items-center py-3 px-4">
                        <span class="text-gray-800">{{ $member->name }}
                            <br>
                            <small class="text-gray-400">{{ $member->email }}</small>
                        </span>
                        <button wire:click="removeMember({{ $member->id }})"
                            class="text-red-600 hover:text-red-800 focus:outline-none focus:ring">
                            Remove
                        </button>
                    </li>
                    @empty
                    <li class="py-3 px-4 text-gray-500 text-center">
                        No members added yet
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>