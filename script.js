const modal = document.getElementById('modal');
const modalShow = document.getElementById('show-modal');
const modalClose = document.getElementById('close-modal');
const bookmarkForm = document.getElementById('bookmark-form');
const websiteNameEl = document.getElementById('website-name');
const websiteUrlEl = document.getElementById('website-url');
const bookmarksContainer = document.getElementById('bookmark-container');

let bookmarks = [];

// show modal and focus on element

function showModal() {
    modal.classList.add('show-modal');
    websiteNameEl.focus();
}

//Event listener to show 
modalShow.addEventListener('click', showModal);
modalClose.addEventListener('click', () => modal.classList.remove('show-modal'));
window.addEventListener('click', (e) => (e.target === modal) ? modal.classList.remove('show-modal') : false);

//Validate Form
function validate(nameValues, nameUrl)
{
    const expression = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/;
    const regExp = new RegExp(expression);

    if (!nameValues || !nameUrl) {
        alert('Please submit values for both fields')
        return false;
    }
    if (!nameUrl.match(regExp)) {
        alert('Please provide a valid web adress');
        return false;
    }
    return true;
}
//Build bookmarks DOM
function buildBookmarks() {
    //remove all bookmarks element
    bookmarksContainer.textContent = '';
    
    bookmarks.forEach((bookmark) => {
       const {name, url} = bookmark;
       //Item 
       const item = document.createElement('div');
       item.classList.add('item');
       //close Icon
       const closeIcon = document.createElement('i');
       closeIcon.classList.add('fas', 'fa-times');
       closeIcon.setAttribute('title', 'Delete bookmark');
       //closeIcon.setAttribute('onclick', `deleteBookmark('${url}')`);
       closeIcon.setAttribute('onclick', `deleteBookmark('${url}')`);
       //Favicon / Link container
       const linkInfo = document.createElement('div');
       linkInfo.classList.add('name');
       //Favicon
       const favicon = document.createElement('img');
       favicon.setAttribute('src', `https://s2.googleusercontent.com/s2/favicons?domain=${url}`);
       favicon.setAttribute('alt', 'Favicon');

       //link
       const link = document.createElement('a');
       link.setAttribute('href', `${url}`);
       link.setAttribute('target', '_blank');
       link.textContent = name;

       //Append to Bookmark container
       linkInfo.append(favicon, link);
       item.append(closeIcon, linkInfo);
       bookmarksContainer.appendChild(item);

    });
}
//Fetch bookmarks
function fetchBookmarks() {
    // Get bookmarks from localstorage if available
    if (localStorage.getItem('bookmarks')) {
        bookmarks = JSON.parse(localStorage.getItem('bookmarks'));
    } else {
        bookmarks = [
            {
                name: 'Jasino',
                url: 'https://jacinto.design',
            },
        ];
        localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
    }
    buildBookmarks();
}

//Delete bookmarks
function deleteBookmark(url) {
    bookmarks.forEach((bookmark, i) => {
        if (bookmark.url === url) {
           // console.log(bookmark.url === url);
            bookmarks.splice(i, 1);
        }
    });
   
    //Update bookmarks in localctorage and re-populate DOM
    localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
    fetchBookmarks();
}

//Handel data from Form
function storeBookmark(e) {
    e.preventDefault();
    const nameValues = websiteNameEl.value;
    let nameUrl = websiteUrlEl.value;

    if (!nameUrl.includes('http://') && !nameUrl.includes('https://')) {
        nameUrl = `https://${nameUrl}`;
    }
    if (!validate(nameValues, nameUrl)) {
        return false;
    }
    const bookmark = {
        name: nameValues,
        url: nameUrl,
    };
    bookmarks.push(bookmark);

    //localstorage
    localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
    //console.log(localStorage.setItem('bookmarks', JSON.stringify(bookmarks)));
    fetchBookmarks();
    bookmarkForm.reset();
    websiteNameEl.focus();

   // console.log(bookmarks);
}


//Form event listener
bookmarkForm.addEventListener('submit', storeBookmark);

//on load
fetchBookmarks();