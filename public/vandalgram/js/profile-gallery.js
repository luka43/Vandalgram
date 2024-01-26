const cardPreviewWrapper = document.getElementById("card-preview-wrapper");
const userCardContainer = document.querySelector("[gallery-item-grid]");
const userCardTemplate = document.querySelector("[card-template]");
const cardPreview = document.getElementById("card-preview");

$.ajax({
    url: 'getdatabase.php',
    dataType: 'json',
    success: function(data) {
        photos = data.map(photo => {

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
        photos.forEach(photo => {
            const isVisible =
            photo.artist.toLowerCase().includes(session_name);
            photo.element.classList.toggle("hide", !isVisible);
        });
    },
    error: function(xhr, status, error) {
        console.log('Error: ' + error.message);
    }
});
function imagePreview(element) {

    for(var i=0; i<element.children.length; i++){
        if(element.children[i].tagName == "IMG") {
            let url = element.children[i].src;
            console.log(url.substring(url.lastIndexOf("/")+1));
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
function goToImage(element) {
    let imgurl = element.src.substring(element.src.lastIndexOf("/")+1);
    console.log(imgurl);
    // window.location.href = "image.php?url=" + imgurl;
    window.location.replace("image.php?url=" + imgurl);
}