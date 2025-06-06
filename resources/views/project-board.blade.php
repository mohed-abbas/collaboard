<x-layouts.app :title="'Project Board'">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:board :project="$project" />
        </div>
    </div>
</x-layouts.app>