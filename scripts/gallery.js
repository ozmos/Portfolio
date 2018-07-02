var images = document.getElementsByClassName("image");
var descriptions = document.getElementsByClassName("description");

for (var i = 0; i < images.length; i++) {
  images[i].id = i;
  descriptions[i].id = i;
  
  images[i].addEventListener("click", function() {
    let index = Number(this.id);
    descriptions[index].classList.toggle("reveal");
});
  descriptions[i].addEventListener("click", function() {
        let index = Number(this.id);
    descriptions[index].classList.toggle("reveal");
});

  
}


