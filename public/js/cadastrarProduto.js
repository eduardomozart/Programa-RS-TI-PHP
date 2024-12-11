window.addEventListener('load', function () {
    // Dropdown toggle
    document.querySelector('.dropdown-btn').addEventListener('click', function () {
        const dropdown = this.parentElement;
        dropdown.classList.toggle('open');
    });

    // Modal logic
    const dropdown = document.getElementById('categoryDropdown');
    const modal = document.getElementById('editModal');
    const overlay = document.querySelector('.modal-overlay');
    const editCategoryName = document.getElementById('editCategoryName');
    let currentLabel;
    onEditCategoryModal();

    document.getElementById('add-btn').addEventListener('click', function (event) {
        event.stopImmediatePropagation(); // Não expandir menu suspenso ao clicar no link de Adicioanr
        document.getElementById('modal-header').innerText = 'Adicionar categoria';
        editCategoryName.value = ''; // Remove o texto da caixa de texto da Modal
        modal.style.display = 'block';
        overlay.style.display = 'block';
    });

    document.getElementById('editCategoryName').addEventListener('click', function () {
        // Posicionar cursor para o final do campo de texto ao invés do início
        this.selectionStart = this.selectionEnd = this.value.length;
    });

    document.getElementById('closeModal').addEventListener('click', function () {
        modal.style.display = 'none';
        overlay.style.display = 'none';
        currentLabel = undefined;
    });

    document.getElementById('saveCategory').addEventListener('click', function () {
        const newName = editCategoryName.value.trim();
        if (newName) {
            if (currentLabel && currentLabel.hasChildNodes()) {
                // Se for edição de categoria (elemento já existe)
                currentLabel.childNodes[2].nodeValue = ` ${newName} `;
                currentLabel = undefined;
            } else {
                // Se for adição de categoria
                dropdown.innerHTML += `<label>
                    <input type="checkbox" value="${newName}" name="categorias[]">
                    ${newName}
                    <button type="button" class="edit-btn">Editar</button>
                </label>`;
                onEditCategoryModal();
            }
            modal.style.display = 'none';
            overlay.style.display = 'none';
        }
    });

    // Fechar o menu se clicar fora dele
    document.addEventListener('click', function (event) {
        const dropdown = document.querySelector('.dropdown');
        if (!dropdown.contains(event.target) && !modal.contains(event.target)) {
            dropdown.classList.remove('open');
            modal.style.display = 'none';
            overlay.style.display = 'none';
            currentLabel = undefined;
        }
    });

    function onEditCategoryModal() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('modal-header').innerText = 'Editar categoria';
                modal.style.display = 'block';
                overlay.style.display = 'block';
                currentLabel = this.parentElement;
                editCategoryName.value = currentLabel.textContent.trim().slice(0, this.textContent.length);
            });
        });
    }
});