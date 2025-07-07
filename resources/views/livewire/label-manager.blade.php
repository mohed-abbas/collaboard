<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-5xl">
        <x-slot name="title">
            <!-- Minimal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                    Gestion des étiquettes
                </h2>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 h-96">

                    <!-- Left Column: Create/Edit Form -->
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-4">
                            {{ $isEditing ? 'Modifier l\'étiquette' : 'Nouvelle étiquette' }}
                        </h3>

                        <form wire:submit.prevent="saveLabel" class="flex-1 flex flex-col space-y-4">
                            <!-- Label Name -->
                            <div>
                                <input id="labelName" type="text" wire:model.live.debounce.300ms="labelName"
                                    class="w-full text-lg font-medium bg-transparent border-0 border-b border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-blue-500 focus:ring-0 px-0 py-2"
                                    placeholder="Nom de l'étiquette">
                                @error('labelName')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Color Selection -->
                            <div>
                                <label
                                    class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wide">
                                    Couleur
                                </label>

                                <!-- Predefined Colors Grid -->
                                <div class="grid grid-cols-6 gap-2 mb-3">
                                    @foreach($predefinedColors as $color)
                                    <button type="button" wire:click="setColor('{{ $color }}')"
                                        class="w-7 h-7 rounded border-2 transition-colors {{ $labelColor === $color ? 'border-slate-400 dark:border-slate-300' : 'border-slate-200 dark:border-slate-600' }}"
                                        style="background-color: {{ $color }};">
                                        @if($labelColor === $color)
                                        <svg class="w-3 h-3 text-white mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        @endif
                                    </button>
                                    @endforeach
                                </div>

                                <!-- Custom Color -->
                                <div class="flex items-center space-x-2">
                                    <input type="color" wire:model="labelColor"
                                        class="w-7 h-7 rounded border border-slate-300 dark:border-slate-600 cursor-pointer">
                                    <input type="text" wire:model="labelColor"
                                        class="flex-1 px-2 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="#3B82F6">
                                </div>
                            </div>

                            <!-- Preview -->
                            <div>
                                <label
                                    class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wide">
                                    Aperçu
                                </label>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white"
                                    style="background-color: {{ $labelColor }}">
                                    {{ $labelName ?: 'Nom de l\'étiquette' }}
                                </span>
                            </div>

                            <!-- Spacer -->
                            <div class="flex-1"></div>

                            <!-- Action Buttons -->
                            <div
                                class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                                <button type="button" wire:click="resetForm"
                                    class="px-3 py-1.5 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                                    {{ $isEditing ? 'Annuler' : 'Effacer' }}
                                </button>

                                <button type="submit"
                                    class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition-colors">
                                    {{ $isEditing ? 'Sauvegarder' : 'Créer' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column: Tag Cloud -->
                    <div class="flex flex-col border-l border-slate-200 dark:border-slate-700 pl-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-slate-900 dark:text-white">
                                Étiquettes existantes
                            </h3>
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                {{ count($labels) }}
                            </span>
                        </div>

                        @if(count($labels) > 0)
                        <!-- Tag Cloud Container -->
                        <div
                            class="flex-1 flex flex-wrap gap-2 content-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-600 max-h-80 overflow-hidden">
                            @foreach($labels as $label)
                            <div class="group relative">
                                <!-- The Tag (clickable to edit) -->
                                <button wire:click="openEditModal({{ $label->id }})"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-white hover:scale-105 transition-all duration-200 cursor-pointer shadow-sm hover:shadow-md"
                                    style="background-color: {{ $label->color }}">
                                    {{ $label->name }}
                                    @if($label->tasks->count() > 0)
                                    <span class="ml-2 px-1.5 py-0.5 bg-white/20 rounded-full text-xs">
                                        {{ $label->tasks->count() }}
                                    </span>
                                    @endif
                                </button>

                                <!-- Delete Button (appears on hover) -->
                                <button
                                    wire:click="{{ $label->tasks->count() > 0 ? 'forceDeleteLabel' : 'deleteLabel' }}({{ $label->id }})"
                                    wire:confirm="{{ $label->tasks->count() > 0 ? 'Supprimer cette étiquette supprimera aussi toutes ses associations ?' : 'Supprimer cette étiquette ?' }}"
                                    class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 transform scale-0 group-hover:scale-100 shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        </div>

                        <!-- Instructions -->
                        <div
                            class="mt-3 p-2 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
                            <p class="text-xs text-blue-700 dark:text-blue-300 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Cliquez sur une étiquette pour la modifier, survolez pour la supprimer
                            </p>
                        </div>
                        @else
                        <!-- Empty State -->
                        <div class="flex-1 flex items-center justify-center">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">
                                    Aucune étiquette
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-500">
                                    Créez votre première étiquette
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>