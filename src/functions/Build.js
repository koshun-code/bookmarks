import { deleteBookmark, sendCategory } from "./Data";


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

export function createCategory(categoriesData) {
    const categories = document.querySelector('#categories');//categories
    categories.textContent = '';
    categoriesData.map((categoryData) => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.setAttribute('href', `http://bookmarks/category/${categoryData.id_category}`);
        a.textContent = categoryData.category_name;
        li.appendChild(a);
        categories.appendChild(li);
    });
}

export function createSelectCategory(data) {
    const select = document.querySelector('.form-select');
    data.map(item => {
        const option = document.createElement('option');
        option.setAttribute("value", item.id_category);
        option.textContent = item.category_name;
        select.appendChild(option);
    })
}

export  function storeCategory(e) {
    e.preventDefault();
    const categoryForm = document.getElementById('category-form');
    const websiteCategory = document.querySelector('#website-category');
    sendCategory(websiteCategory.value);
    categoryForm.reset();
    websiteCategory.focus()
}