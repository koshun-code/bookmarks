export function showModal() {
    const websiteUrlEl = document.getElementById('website-url');//website-url
    modal.classList.add('show-modal');
    websiteUrlEl.focus();
}

export function showModalCategory(event) {
    event.preventDefault();
    const websiteCategory = document.getElementById('website-category');
    const modalCategory = document.getElementById('modal-category');
    modalCategory.classList.add('show-modal');
    websiteCategory.focus();
}