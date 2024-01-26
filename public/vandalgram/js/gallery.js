const cardPreviewWrapper = document.getElementById("card-preview-wrapper");
const searchInput = document.querySelector("[data-search]");
const userCardContainer = document.querySelector("[gallery-item-grid]");
const userCardTemplate = document.querySelector("[card-template]");
const cardPreview = document.getElementById("card-preview");
const body = document.getElementById("body");
var artistt = "";
var category = "all";
var photos = [];
var value = [];
document.addEventListener('keydown', (event) => {

    if (event.key === 'Escape') {
            cardPreviewWrapper.style.display = "none";
    }})

updateGallery();
filterCategory(category);

searchInput.addEventListener('input', e => {
    var value = e.target.value.toLowerCase();
    artistt = value;
        photos.forEach(photo => {

            if (category != "all"){
                    const isVisible =
                        photo.artist.toLowerCase().includes(value) && photo.category.toLowerCase().includes(category.toLowerCase());
                    photo.element.classList.toggle("hide", !isVisible);
            } else {
                const isVisible =
                            photo.artist.toLowerCase().includes(value);
                        photo.element.classList.toggle("hide", !isVisible);
            }
        }
    )
});

function filterCategory(value) {
    category = value.toLowerCase();
    if (value.toLowerCase() === "all") {

        if (artistt === "" || artistt === " ") {
            photos.forEach(photo => {
                photo.element.classList.toggle("hide", false);
            })
        }
        else {
            photos.forEach(photo => {
                const isVisible =
                    photo.artist.toLowerCase().includes(artistt)
                photo.element.classList.toggle("hide", !isVisible);
        })
    }
    } else {
        photos.forEach(photo => {
            const isVisible =
                photo.category.toLowerCase().includes(category) && photo.artist.toLowerCase().includes(artistt);

            photo.element.classList.toggle("hide", !isVisible);
        })
    }

    for(let i=0; i<document.getElementById("item-category").children.length; i++){
        document.getElementById("item-category").children[i].classList.toggle("active-item", false)
    }
    document.getElementById(value).classList.toggle("active-item", true);
}

function imagePreview(element) {

        for(var i=0; i<element.children.length; i++){
            if(element.children[i].tagName == "IMG") {
                let url = element.children[i].src;
                cardPreview.children[i].src = "uploads/" + url.substring(url.lastIndexOf("/")+1);
            }
            else {
                cardPreview.children[i].textContent = element.children[i].textContent;
            }

        }
        cardPreviewWrapper.style.display = "flex";
        document.getElementById("body").style.overflow = "hidden";
}

function closeImagePreview(element) {
        cardPreviewWrapper.style.display = "none";
        document.getElementById("body").style.overflow = "auto";
}
function clearInputs() {
    artistt = "";
    category = "all";
    filterCategory("all");
    document.getElementById("artist").value = "";
}
function goToImage(element) {
    let imgurl = element.src.substring(element.src.lastIndexOf("/")+1);
    // window.location.href = "image.php?url=" + imgurl;
    window.location.replace("image.php?url=" + imgurl);
}
function goToProfile(element) {
    let profile = element.textContent;
    // window.location.href = "image.php?url=" + imgurl;
    window.location.replace("profile.php?artist=" + profile);
}
function updateGallery() {
    category = "all";
    $.ajax({
        url: "getdatabase.php",
        dataType: 'json',
        success: function(data) {
            photos = data.slice(0).reverse().map(photo => {

                const card = userCardTemplate.content.cloneNode(true).children[0]
    
                const header = card.querySelector("[card-header]");
                const image = card.querySelector("[card-image]");
                const title = card.querySelector("[card-title]");
                const category = card.querySelector("[card-category");
                const description = card.querySelector("[card-description]");
                const location = card.querySelector("[card-location]");
    
                header.textContent = photo.artist;
                image.src = "uploads/thumbnails/" + photo.url;
                title.textContent = photo.title;
                category.textContent = photo.category;
                description.textContent = photo.description;
                location.textContent = photo.country + ', ' + photo.city;
    
                userCardContainer.append(card)
                return { artist: photo.artist, title: photo.title, category: photo.category, description: photo.description, location: photo.country+photo.city, element: card }
            });
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error.message);
        }
    });
}