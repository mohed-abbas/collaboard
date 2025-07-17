
    // Prevent multiple initializations
    window.boardDragDropInitialized = window.boardDragDropInitialized || false;

    document.addEventListener('DOMContentLoaded', function () {
        if (!window.boardDragDropInitialized) {
            initBoardDragAndDrop();
            window.boardDragDropInitialized = true;
        }
    });

    function initBoardDragAndDrop() {
        console.log('Initializing board drag and drop');

        let draggedElement = null;
        let draggedTaskId = null;
        let draggedFromCategory = null;
        let isDragging = false;
        let dropExecuted = false;

        // Create a single event handler instance
        const dragDropHandler = {
            handleDragStart: function (e) {
                // Only handle if target is a task item
                const taskElement = e.target.closest('.task-item');
                if (!taskElement) return;

                e.stopPropagation();

                console.log('Drag start triggered for task:', taskElement.dataset.taskId);

                draggedElement = taskElement;
                draggedTaskId = taskElement.dataset.taskId;
                draggedFromCategory = taskElement.dataset.categoryId;
                isDragging = true;
                dropExecuted = false;

                taskElement.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', draggedTaskId);

                // Disable pointer events temporarily
                setTimeout(() => {
                    if (taskElement) {
                        taskElement.style.pointerEvents = 'none';
                    }
                }, 0);
            },

            handleDragEnd: function (e) {
                const taskElement = e.target.closest('.task-item');
                if (!taskElement) return;

                console.log('Drag end triggered');

                taskElement.classList.remove('dragging');
                taskElement.style.pointerEvents = 'auto';

                // Remove drag-over styles from all categories
                document.querySelectorAll('.category-column').forEach(col => {
                    col.classList.remove('drag-over');
                });

                // Reset state after a delay
                setTimeout(() => {
                    isDragging = false;
                    dropExecuted = false;
                    draggedElement = null;
                    draggedTaskId = null;
                    draggedFromCategory = null;
                }, 100);
            },

            handleDragOver: function (e) {
                if (!isDragging) return;

                e.preventDefault();
                e.stopPropagation();

                const categoryColumn = e.target.closest('.category-column');
                if (categoryColumn && draggedElement) {
                    e.dataTransfer.dropEffect = 'move';

                    // Remove drag-over from all other columns
                    document.querySelectorAll('.category-column').forEach(col => {
                        if (col !== categoryColumn) {
                            col.classList.remove('drag-over');
                        }
                    });

                    categoryColumn.classList.add('drag-over');
                }
            },

            handleDragLeave: function (e) {
                if (!isDragging) return;

                const categoryColumn = e.target.closest('.category-column');
                if (categoryColumn) {
                    // Check if we're actually leaving the category
                    const rect = categoryColumn.getBoundingClientRect();
                    const x = e.clientX;
                    const y = e.clientY;

                    if (x < rect.left || x > rect.right || y < rect.top || y > rect.bottom) {
                        categoryColumn.classList.remove('drag-over');
                    }
                }
            },

            handleDrop: function (e) {
                if (!isDragging || dropExecuted) return;

                e.preventDefault();
                e.stopPropagation();

                console.log('Drop triggered');
                dropExecuted = true;

                const categoryColumn = e.target.closest('.category-column');
                if (categoryColumn && draggedTaskId) {
                    const newCategoryId = categoryColumn.dataset.categoryId;

                    console.log('Dropping task:', draggedTaskId, 'into category:', newCategoryId, 'from:',
                        draggedFromCategory);

                    // Only proceed if dropping in a different category
                    if (newCategoryId && newCategoryId !== draggedFromCategory) {
                        console.log('Dispatching taskMoved event');

                        // Dispatch Livewire event
                        window.Livewire.dispatch('taskMoved', {
                            taskId: parseInt(draggedTaskId),
                            newCategoryId: parseInt(newCategoryId)
                        });
                    } else {
                        console.log('Same category - no action needed');
                    }

                    categoryColumn.classList.remove('drag-over');
                }
            }
        };

        // Remove any existing listeners first
        document.removeEventListener('dragstart', dragDropHandler.handleDragStart, true);
        document.removeEventListener('dragend', dragDropHandler.handleDragEnd, true);
        document.removeEventListener('dragover', dragDropHandler.handleDragOver, true);
        document.removeEventListener('dragleave', dragDropHandler.handleDragLeave, true);
        document.removeEventListener('drop', dragDropHandler.handleDrop, true);

        // Add event listeners with capture flag
        document.addEventListener('dragstart', dragDropHandler.handleDragStart, true);
        document.addEventListener('dragend', dragDropHandler.handleDragEnd, true);
        document.addEventListener('dragover', dragDropHandler.handleDragOver, true);
        document.addEventListener('dragleave', dragDropHandler.handleDragLeave, true);
        document.addEventListener('drop', dragDropHandler.handleDrop, true);

        // Store handler reference for cleanup
        window.boardDragDropHandler = dragDropHandler;
    }

    // Cleanup and reinitialize after Livewire updates
    document.addEventListener('livewire:updated', function () {
        console.log('Livewire updated - reinitializing drag drop');

        // Clean up existing handlers
        if (window.boardDragDropHandler) {
            document.removeEventListener('dragstart', window.boardDragDropHandler.handleDragStart, true);
            document.removeEventListener('dragend', window.boardDragDropHandler.handleDragEnd, true);
            document.removeEventListener('dragover', window.boardDragDropHandler.handleDragOver, true);
            document.removeEventListener('dragleave', window.boardDragDropHandler.handleDragLeave, true);
            document.removeEventListener('drop', window.boardDragDropHandler.handleDrop, true);
        }

        // Reset initialization flag
        window.boardDragDropInitialized = false;

        // Reinitialize after a short delay
        setTimeout(() => {
            initBoardDragAndDrop();
            window.boardDragDropInitialized = true;
        }, 100);
    });
