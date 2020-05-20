document.querySelectorAll(`button.showSolution`).forEach(function (button) {
    button.addEventListener(`click`, function (event) {
        let taskId = this.getAttribute(`data-task-id`);
        let solutionDiv = document.querySelector(`div[data-task-id="${taskId}"]`);

        if (solutionDiv.classList.contains('hidden')) {
            alert('Czy chcesz wyświetlić rozwiązanie zadania?');
            solutionDiv.classList.remove('hidden');
            this.textContent = 'Ukryj rozwiązanie';
        } else {
            solutionDiv.classList.add('hidden');
            this.textContent = 'Pokaż rozwiązanie';
        }
    });
});
