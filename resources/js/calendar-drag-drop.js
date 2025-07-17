class CalendarDragDrop {
    constructor() {
        this.draggedElement = null;
        this.draggedTaskId = null;
        this.draggedFromDate = null;
        this.isDragging = false;
        this.dropExecuted = false;
        this.initialized = false;
        
        this.init();
    }

    init() {
        if (this.initialized) return;
        
        console.log('Initializing calendar drag and drop');
        this.bindEvents();
        this.initialized = true;
    }

    bindEvents() {
        // Remove existing listeners
        this.removeEventListeners();
        
        // Add new listeners with capture
        document.addEventListener('dragstart', this.handleDragStart.bind(this), true);
        document.addEventListener('dragend', this.handleDragEnd.bind(this), true);
        document.addEventListener('dragover', this.handleDragOver.bind(this), true);
        document.addEventListener('dragleave', this.handleDragLeave.bind(this), true);
        document.addEventListener('drop', this.handleDrop.bind(this), true);
    }

    removeEventListeners() {
        document.removeEventListener('dragstart', this.handleDragStart, true);
        document.removeEventListener('dragend', this.handleDragEnd, true);
        document.removeEventListener('dragover', this.handleDragOver, true);
        document.removeEventListener('dragleave', this.handleDragLeave, true);
        document.removeEventListener('drop', this.handleDrop, true);
    }

    handleDragStart(e) {
        // Only handle calendar task items
        const taskElement = e.target.closest('.calendar-task-item');
        if (!taskElement) return;

        e.stopPropagation();
        console.log('Calendar drag start triggered for task:', taskElement.dataset.taskId);

        this.draggedElement = taskElement;
        this.draggedTaskId = taskElement.dataset.taskId;
        this.draggedFromDate = taskElement.dataset.taskDate;
        this.isDragging = true;
        this.dropExecuted = false;

        taskElement.classList.add('calendar-dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', this.draggedTaskId);

        // Disable pointer events temporarily
        setTimeout(() => {
            if (taskElement) {
                taskElement.style.pointerEvents = 'none';
            }
        }, 0);
    }

    handleDragEnd(e) {
        const taskElement = e.target.closest('.calendar-task-item');
        if (!taskElement) return;

        console.log('Calendar drag end triggered');

        taskElement.classList.remove('calendar-dragging');
        taskElement.style.pointerEvents = 'auto';

        // Remove drag-over styles from all calendar days
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('calendar-drag-over');
        });

        // Reset state after a delay
        setTimeout(() => {
            this.isDragging = false;
            this.dropExecuted = false;
            this.draggedElement = null;
            this.draggedTaskId = null;
            this.draggedFromDate = null;
        }, 100);
    }

    handleDragOver(e) {
        if (!this.isDragging) return;

        e.preventDefault();
        e.stopPropagation();

        const calendarDay = e.target.closest('.calendar-day');
        if (calendarDay && this.draggedElement) {
            e.dataTransfer.dropEffect = 'move';

            // Remove drag-over from all other days
            document.querySelectorAll('.calendar-day').forEach(day => {
                if (day !== calendarDay) {
                    day.classList.remove('calendar-drag-over');
                }
            });

            calendarDay.classList.add('calendar-drag-over');
        }
    }

    handleDragLeave(e) {
        if (!this.isDragging) return;

        const calendarDay = e.target.closest('.calendar-day');
        if (calendarDay) {
            const rect = calendarDay.getBoundingClientRect();
            const x = e.clientX;
            const y = e.clientY;

            if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
                calendarDay.classList.remove('calendar-drag-over');
            }
        }
    }

    handleDrop(e) {
        if (!this.isDragging || this.dropExecuted) return;

        e.preventDefault();
        e.stopPropagation();

        console.log('Calendar drop triggered');
        this.dropExecuted = true;

        const calendarDay = e.target.closest('.calendar-day');
        if (calendarDay && this.draggedTaskId) {
            const newDate = calendarDay.dataset.date;

            console.log('Dropping task:', this.draggedTaskId, 'on date:', newDate, 'from:', this.draggedFromDate);

            // Only proceed if dropping on a different date
            if (newDate && newDate !== this.draggedFromDate) {
                console.log('Dispatching taskDateMoved event');

                // Dispatch Livewire event for calendar date change
                window.Livewire.dispatch('taskDateMoved', {
                    taskId: parseInt(this.draggedTaskId),
                    newDate: newDate
                });
            } else {
                console.log('Same date - no action needed');
            }

            calendarDay.classList.remove('calendar-drag-over');
        }
    }

    reinitialize() {
        console.log('Reinitializing calendar drag drop after Livewire update');
        this.initialized = false;
        this.removeEventListeners();
        
        setTimeout(() => {
            this.init();
        }, 100);
    }

    destroy() {
        this.removeEventListeners();
        this.initialized = false;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    if (!window.calendarDragDrop) {
        window.calendarDragDrop = new CalendarDragDrop();
    }
});

// Reinitialize after Livewire updates
document.addEventListener('livewire:updated', function() {
    if (window.calendarDragDrop) {
        window.calendarDragDrop.reinitialize();
    }
});