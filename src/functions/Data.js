import { buildBookmarks } from "./Build";
import { chechUrlScheme, validate } from "./Validate";
import axios from "axios";

const websiteNameEl = document.getElementById('website-name');
const websiteUrlEl = document.getElementById('website-url');
const bookmarkForm = document.getElementById('bookmark-form');

axios.create({
    baseURL: "http://bookmarks/api/"
})

export async function getTitle(send) {
    // console.log(send);
    const response = await axios.post('http://bookmarks/api/bookmarks/title/', {
        url: send,
        headers: {
            "Content-type": "application/json; charset=UTF-8"
          }
    })
    const data = await response.data;
    websiteNameEl.value = data.title
    
}

//Fetch bookmarks
export async function  fetchBookmarks() {
    const response = await fetch("http://bookmarks/api/bookmarks");
    const bookmarks = await response.json();

    buildBookmarks(bookmarks);
}

//Delete bookmarks
export async function deleteBookmark(id) {
    const deleteId = Number(id);
    const response = await fetch(`http://bookmarks/api/bookmarks/${deleteId}`, {
        method: "delete",
        cache: 'no-cache'
    });
    const json = await response.json();
    fetchBookmarks();
}

export const sendBookmark = async (bookmark) => {
    //console.log(JSON.stringify(bookmark));
    const response = await fetch("http://bookmarks/api/bookmarks", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(bookmark)
        /**
         *  headers: {
                'Content-Type': 'application/json;charset=utf-8'
  },
             body: JSON.stringify(user)
         */
    });
    const json = await response.json();
    fetchBookmarks();
}

export function storeBookmark(e) {
    e.preventDefault();
    const nameValues = websiteNameEl.value;
    let nameUrl = websiteUrlEl.value;

    nameUrl = chechUrlScheme(nameUrl);

    if (!validate(nameValues, nameUrl)) {
        return false;
    }

    const bookmark = {
        name: nameValues,
        url: nameUrl,
    };
    sendBookmark(bookmark);
    //fetchBookmarks();
    bookmarkForm.reset();
    websiteUrlEl.focus();
}