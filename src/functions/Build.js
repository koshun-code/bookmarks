import { deleteBookmark } from "./Data";


export function buildBookmarks(bookmarks) {
    const bookmarksContainer = document.getElementById('bookmark-container');
    //remove all bookmarks element
    bookmarksContainer.textContent = '';
    
    bookmarks.forEach((bookmark) => {
       const {name, url, id} = bookmark;
       //Item 
       const item = document.createElement('div');
       item.classList.add('item');
       //close Icon
       const closeIcon = document.createElement('i');
       closeIcon.classList.add('fas', 'fa-times', 'delete-bm');
       closeIcon.setAttribute('title', 'Delete bookmark');
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
       closeIcon.addEventListener('click', () => {
        deleteBookmark(id)
       })
    });
}