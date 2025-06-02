<!-- filepath: /home/woze/Projet-annuel-Laravel/collaboard/resources/views/projects/project-board.blade.php -->
<x-layouts.app :title="$project->name">
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- En-tête du projet -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $project->description }}</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                    Retour aux projets
                </a>
            </div>
        </div>
        
        <!-- Tableau Kanban -->
        <div x-data="kanban()" class="mt-6">
            <div class="flex space-x-4 overflow-x-auto pb-6">
                <!-- Boucle sur les listes -->
                <template x-for="(liste, indexListe) in listes" :key="'liste-'+indexListe">
                    <div class="bg-gray-100 rounded-lg shadow min-w-[18rem] w-72">
                        <!-- Entête de liste avec titre éditable -->
                        <div class="flex items-center justify-between p-3 border-b border-gray-200">
                            <div 
                                x-show="!liste.editMode" 
                                @click="editListTitle(indexListe)"
                                class="font-medium text-gray-800 cursor-pointer"
                                x-text="liste.titre">
                            </div>
                            <input 
                                type="text" 
                                x-show="liste.editMode" 
                                x-model="liste.titre"
                                @blur="liste.editMode = false"
                                @keydown.enter="liste.editMode = false"
                                class="border-0 bg-transparent font-medium focus:ring-0 w-full"
                                x-ref="listTitleInput">
                            <button @click="supprimerListe(indexListe)" class="text-gray-500 hover:text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Cartes dans la liste -->
                        <div 
                            class="min-h-[50px] p-2"
                            @dragover.prevent
                            @drop="dropCarte($event, indexListe)">
                            <template x-for="(carte, indexCarte) in liste.cartes" :key="'carte-'+indexCarte">
                                <div 
                                    class="bg-white p-3 rounded shadow mb-2 cursor-pointer"
                                    draggable="true"
                                    @dragstart="dragStart($event, indexListe, indexCarte)"
                                    @click="ouvrirCarte(indexListe, indexCarte)">
                                    <div class="font-medium" x-text="carte.titre"></div>
                                    <div class="text-sm text-gray-600 mt-1 line-clamp-3" x-text="carte.description"></div>
                                </div>
                            </template>
                            
                            <!-- Bouton pour ajouter une carte -->
                            <button 
                                @click="ajouterCarte(indexListe)" 
                                class="w-full mt-2 py-2 px-3 text-gray-600 text-sm text-left hover:bg-gray-200 rounded">
                                + Ajouter une carte
                            </button>
                        </div>
                    </div>
                </template>
                
                <!-- Bouton pour ajouter une nouvelle liste -->
                <div class="bg-gray-50 rounded-lg shadow min-w-[18rem] w-72 flex items-center justify-center">
                    <button 
                        @click="ajouterListe()"
                        class="text-gray-600 hover:bg-gray-200 py-2 px-4 rounded w-full text-center">
                        + Ajouter une liste
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function kanban() {
            return {
                listes: [
                    { titre: 'À faire', editMode: false, cartes: [] },
                    { titre: 'En cours', editMode: false, cartes: [] },
                    { titre: 'Terminé', editMode: false, cartes: [] }
                ],
                dragInfo: {
                    listIndex: null,
                    cardIndex: null
                },
                
                init() {
                    // En production, charger les données depuis le serveur
                    // this.chargerDonnees();
                },
                
                // Gestion des listes
                ajouterListe() {
                    const titre = prompt('Nom de la nouvelle liste:');
                    if (titre && titre.trim()) {
                        this.listes.push({
                            titre: titre,
                            editMode: false,
                            cartes: []
                        });
                    }
                },
                
                editListTitle(indexListe) {
                    this.listes[indexListe].editMode = true;
                    this.$nextTick(() => {
                        this.$refs.listTitleInput.focus();
                    });
                },
                
                supprimerListe(indexListe) {
                    if (confirm('Supprimer cette liste et toutes ses cartes ?')) {
                        this.listes.splice(indexListe, 1);
                    }
                },
                
                // Gestion des cartes
                ajouterCarte(indexListe) {
                    const titre = prompt('Titre de la carte:');
                    if (titre && titre.trim()) {
                        const description = prompt('Description (optionnelle):');
                        this.listes[indexListe].cartes.push({
                            titre: titre,
                            description: description || ''
                        });
                    }
                },
                
                ouvrirCarte(indexListe, indexCarte) {
                    const carte = this.listes[indexListe].cartes[indexCarte];
                    const nouveauTitre = prompt('Titre:', carte.titre);
                    
                    if (nouveauTitre !== null) {
                        const nouvelleDescription = prompt('Description:', carte.description);
                        
                        if (nouvelleDescription !== null) {
                            this.listes[indexListe].cartes[indexCarte] = {
                                titre: nouveauTitre,
                                description: nouvelleDescription
                            };
                        }
                    }
                },
                
                // Fonctions de drag & drop
                dragStart(event, listIndex, cardIndex) {
                    this.dragInfo = {
                        listIndex: listIndex,
                        cardIndex: cardIndex
                    };
                    
                    event.dataTransfer.effectAllowed = 'move';
                },
                
                dropCarte(event, targetListIndex) {
                    const { listIndex, cardIndex } = this.dragInfo;
                    
                    if (listIndex === null || cardIndex === null) return;
                    
                    // Récupérer la carte à déplacer
                    const carte = this.listes[listIndex].cartes[cardIndex];
                    
                    // Supprimer la carte de sa position d'origine
                    this.listes[listIndex].cartes.splice(cardIndex, 1);
                    
                    // Ajouter la carte à sa nouvelle position
                    this.listes[targetListIndex].cartes.push(carte);
                    
                    // Réinitialiser les infos de drag
                    this.dragInfo = {
                        listIndex: null,
                        cardIndex: null
                    };
                }
            };
        }
    </script>
    @endpush
</x-layouts.app>
