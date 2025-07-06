<x-modal.dialog wire:model="showModal" class="w-full max-w-lg">
    <x-slot name="title">
        <!-- Clean Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                {{ $isEditing ? 'Modifier le projet' : 'Nouveau projet' }}
            </h2>
        </div>
    </x-slot>

    <x-slot name="newContent">
        <div class="px-6 py-6">
            <form wire:submit.prevent="{{ $isEditing ? 'updateProject' : 'createProject' }}" class="space-y-5">

                <!-- Project Name -->
                <div>
                    <label for="projectName" class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Nom du projet <span class="text-red-500">*</span>
                    </label>
                    <input id="projectName" type="text" wire:model="name" placeholder="Entrez le nom du projet"
                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                        Description
                    </label>
                    <textarea id="description" rows="3" wire:model.defer="description"
                        placeholder="Description du projet (optionnel)"
                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box (Optional) -->
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                Vous pourrez ajouter des membres, créer des catégories et gérer les tâches après la
                                création du projet.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium transition-colors">
                        Annuler
                    </button>

                    <div class="flex space-x-3">
                        @if($isEditing)
                        <button type="button" wire:click="deleteProject"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                            Supprimer
                        </button>
                        @endif
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            {{ $isEditing ? 'Mettre à jour' : 'Créer le projet' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>
</x-modal.dialog>