<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-5xl">
        <x-slot name="title">
            <!-- Premium Header -->
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-slate-900 dark:bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white dark:text-slate-900" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-medium text-slate-900 dark:text-white">
                        Gestion des étiquettes
                    </h2>
                </div>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column: Create/Edit Form -->
                    <div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-1">
                                    {{ $isEditing ? 'Modifier l\'étiquette' : 'Nouvelle étiquette' }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $isEditing ? 'Modifiez les détails de cette étiquette' : 'Créez une nouvelle étiquette pour organiser vos tâches' }}
                                </p>
                            </div>

                            <form wire:submit.prevent="saveLabel" class="space-y-5">
                                <!-- Name and Color in one row -->
                                <div class="grid grid-cols-1 gap-4">
                                    <!-- Label Name -->
                                    <div>
                                        <input type="text" wire:model.live.debounce.300ms="labelName"
                                            class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 focus:ring-2 focus:ring-slate-900 dark:focus:ring-white focus:border-transparent transition-colors"
                                            placeholder="Nom de l'étiquette">
                                        @error('labelName')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Color Picker -->
                                    <div class="flex items-center space-x-3">
                                        <input type="color" wire:model="labelColor"
                                            class="w-12 h-12 rounded-lg border border-slate-300 dark:border-slate-600 cursor-pointer">
                                        <input type="text" wire:model="labelColor"
                                            class="flex-1 px-3 py-3 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-900 dark:focus:ring-white focus:border-transparent"
                                            placeholder="#060606" pattern="^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$">
                                    </div>
                                </div>

                                <!-- Quick Colors -->
                                <div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">Couleurs rapides</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($predefinedColors as $color)
                                            <button type="button" wire:click="setColor('{{ $color }}')"
                                                class="w-8 h-8 rounded-lg transition-all hover:scale-110 border-2 {{ $labelColor === $color ? 'border-slate-900 dark:border-white' : 'border-transparent' }}"
                                                style="background-color: {{ $color }};">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Preview and Action -->
                                <div
                                    class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm text-slate-600 dark:text-slate-400">Aperçu:</span>
                                        @if($labelName)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded text-sm font-medium text-white"
                                                style="background-color: {{ $labelColor }}">
                                                {{ $labelName }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-slate-300 dark:bg-slate-600 text-slate-600 dark:text-slate-400">
                                                Nom de l'étiquette
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        @if($isEditing)
                                            <button type="button" wire:click="resetForm"
                                                class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                                                Annuler
                                            </button>
                                        @endif
                                        <button type="submit"
                                            class="px-6 py-2 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded-lg transition-colors">
                                            {{ $isEditing ? 'Sauvegarder' : 'Créer' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column: Labels Cloud -->
                    <div>
                        @if(count($labels) > 0)
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-sm font-medium text-slate-900 dark:text-white">
                                        Étiquettes existantes
                                    </h3>
                                    <span
                                        class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">
                                        {{ count($labels) }} étiquette{{ count($labels) > 1 ? 's' : '' }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    @foreach($labels as $label)
                                        <div class="group relative">
                                            <button wire:click="openEditModal({{ $label->id }})"
                                                class="inline-flex items-center px-4 py-2 rounded text-sm font-medium text-white transition-all hover:scale-105 shadow-sm"
                                                style="background-color: {{ $label->color }}">
                                                {{ $label->name }}
                                                @if($label->tasks->count() > 0)
                                                    <span class="ml-2 bg-white/30 px-2 py-0.5 rounded text-xs">
                                                        {{ $label->tasks->count() }}
                                                    </span>
                                                @endif
                                            </button>

                                            <!-- Delete button on hover -->
                                            <button
                                                wire:click="{{ $label->tasks->count() > 0 ? 'forceDeleteLabel' : 'deleteLabel' }}({{ $label->id }})"
                                                wire:confirm="{{ $label->tasks->count() > 0 ? 'Supprimer cette étiquette supprimera aussi toutes ses associations ?' : 'Supprimer cette étiquette ?' }}"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all transform scale-75 group-hover:scale-100 shadow-lg">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">
                                    Cliquez pour modifier, survolez pour supprimer
                                </p>
                            </div>
                        @else
                            <div
                                class="text-center py-8 bg-slate-50 dark:bg-slate-800/50 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Aucune étiquette</h3>
                                <p class="text-slate-500 dark:text-slate-400 mb-4">Créez votre première étiquette pour
                                    organiser vos
                                    tâches</p>
                                <div class="flex flex-wrap justify-center gap-2">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-500 text-white">Urgent</span>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-500 text-white">Design</span>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-500 text-white">Bug</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>