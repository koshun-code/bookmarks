import { showModal } from "./functions/ShowModal";
import { getTitle, storeBookmark, fetchBookmarks } from "./functions/Data";


const modal = document.getElementById('modal');
const modalShow = document.getElementById('show-modal');
const modalClose = document.getElementById('close-modal');
const bookmarkForm = document.getElementById('bookmark-form');
const websiteNameEl = document.getElementById('website-name');
const websiteUrlEl = document.getElementById('website-url');

let bookmarks = [];

//Event listener to show 
modalShow.addEventListener('click', showModal);
modalClose.addEventListener('click', () => modal.classList.remove('show-modal'));
window.addEventListener('click', (e) => (e.target === modal) ? modal.classList.remove('show-modal') : false);



websiteUrlEl.onblur = () => {
         getTitle(websiteUrlEl.value);
    }

//Form event listener
bookmarkForm.addEventListener('submit', storeBookmark);

//on load
fetchBookmarks();