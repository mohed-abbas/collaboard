<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <header class="mb-12">
            <div class="flex items-center justify-between mb-6">
              <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">Dashboard</h1>
                <p class="text-lg text-gray-600">Welcome back! Here's an overview of your projects</p>
              </div>
              <button
                wire:click="openCreateModal"
                class="flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
              >
                <i class="mr-2">+</i>
                <span class="font-semibold">New Project</span>
              </button>
            </div>
          </header>
  
          <section class="mb-10">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">My Projects</h2>
                    <span class="ml-4 px-4 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        {{ $projects->count() }}
                    </span>
                </div>
            </div>
            
            @if($projects->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($projects as $project)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden transform hover:-translate-y-1">
                        <div class="p-6">
                          <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                              {{ $project->name }}
                            </h3>
                            <div class="relative" x-data="{ open: false }">
                              <button
                                @click="open = !open"
                                class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none transition-colors duration-200"
                              >
                                <!-- SVG icon for more options -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                              </button>
                              <div x-show="open" 
                                   class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-10 animate-fade-in"
                                   @click.outside="open = false">
                                <button
                                  wire:click="openEditModal({{ $project->id }})"
                                  @click="open = false"
                                  class="flex w-full items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 first:rounded-t-lg"
                                >
                                  <!-- Edit icon -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                  </svg>
                                  Edit Project
                                </button>
                                <button
                                  wire:click="deleteProject({{ $project->id }})"
                                  @click="open = false"
                                  onclick="confirm('Delete this project?') || event.stopImmediatePropagation()"
                                  class="flex w-full items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 last:rounded-b-lg border-t border-gray-100"
                                >
                                  <!-- Delete icon -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                  </svg>
                                  Delete Project
                                </button>
                              </div>
                            </div>
                          </div>
                          <p class="text-gray-600 mb-6 line-clamp-2 min-h-[48px]">
                            {{ $project->description ?? 'No description provided' }}
                          </p>
                          <div class="pt-4 border-t border-gray-100">
                            <a href="{{ route('project.board', $project->id) }}" class="w-full py-2.5 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors duration-200 font-medium text-sm flex items-center justify-center">
                                View Board
                            </a>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center bg-white rounded-2xl shadow-sm border border-dashed border-gray-300 p-12">
                    <div class="bg-blue-50 p-4 rounded-full mb-6">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">No projects yet</h3>
                    <p class="text-gray-600 text-center mb-8 max-w-md">
                        Get started by creating your first project. You can track progress, set milestones, and collaborate with your team.
                    </p>
                    <button
                        wire:click="openCreateModal"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Create Your First Project
                    </button>
                </div>
            @endif
          </section>
        </div>
    </div>

    {{-- Modal pour créer/éditer un projet --}}
    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 z-50 overflow-auto bg-black/50 flex items-center justify-center p-4">
        <div x-show="show" x-transition class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 mx-auto">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    {{ $isEditing ? 'Edit Project' : 'Create New Project' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="{{ $isEditing ? 'updateProject' : 'createProject' }}">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                    <input wire:model="name" id="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        {{ $isEditing ? 'Update Project' : 'Create Project' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
