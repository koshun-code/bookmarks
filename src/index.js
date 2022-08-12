import { showModal, showModalCategory } from "./functions/ShowModal";
import { getTitle, storeBookmark, fetchBookmarks, giveCategory } from "./functions/Data";
import { storeCategory } from "./functions/Build";


const modal = document.getElementById('modal');
const modalShow = document.getElementById('show-modal');
const modalClose = document.getElementById('close-modal');
const bookmarkForm = document.getElementById('bookmark-form');
const websiteNameEl = document.getElementById('website-name');
const websiteUrlEl = document.getElementById('website-url');
const modalCategoryShow = document.getElementById('modal-category-show');
const modalCategory = document.getElementById('modal-category');
const closeModalCategory = document.getElementById('close-modal-category');
const categoryForm = document.getElementById('category-form');

let bookmarks = [];

//Event listener to show 
modalShow.addEventListener('click', showModal);
modalCategoryShow.addEventListener('click', showModalCategory);
closeModalCategory.addEventListener('click', () => modalCategory.classList.remove('show-modal'));
window.addEventListener('click', (e) => (e.target === modalCategory) ? modalCategory.classList.remove('show-modal') : false);
modalClose.addEventListener('click', () => modal.classList.remove('show-modal'));
window.addEventListener('click', (e) => (e.target === modal) ? modal.classList.remove('show-modal') : false);



websiteUrlEl.onblur = () => {
         getTitle(websiteUrlEl.value);
    }

//Form event listener
bookmarkForm.addEventListener('submit', storeBookmark);
categoryForm.addEventListener('submit', storeCategory);

//on load
fetchBookmarks();
giveCategory();