document.getElementById("python-title").addEventListener("click", () =>{

    var list = document.getElementById("python-list").children;
    var dropdownIcon = document.getElementById("python-plus-icon");

    if (list[0].style.maxHeight === "0px") {

        dropdownIcon.src = "images/icons/minus-icon.png";

        for (let i = 0; i < list.length; i++){
            list[i].style.maxHeight = "500px";
        }
    }
    else if (list[0].style.maxHeight === "500px"){

        dropdownIcon.src = "images/icons/plus-icon.png";

        for (let i = 0; i < list.length; i++){
            list[i].style.maxHeight = "0px";
        }
    }
});

document.getElementById("webdev-title").addEventListener("click", () =>{

    var list = document.getElementById("webdev-list").children;
    var dropdownIcon = document.getElementById("webdev-plus-icon");

    if (list[0].style.maxHeight === "0px") {

        dropdownIcon.src = "images/icons/minus-icon.png";

        for (let i = 0; i < list.length; i++){
            list[i].style.maxHeight = "500px";
        }
    }
    else if (list[0].style.maxHeight === "500px"){

        dropdownIcon.src = "images/icons/plus-icon.png";

        for (let i = 0; i < list.length; i++){
            list[i].style.maxHeight = "0px";
        }
    }
});