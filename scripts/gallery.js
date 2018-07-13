var tiles = document.querySelectorAll('.project-tile');
var titleElements = document.getElementsByClassName('project-title');
var titles = [];
var labels = document.createElement('span');

for (let i = 0; i < tiles.length; i++) {

}
tiles.forEach(tile => tile.insertBefore(labels, tile.firstChild));
labels.forEach(label => label.classList.add('image-label'));
for (let i = 0; i < titleElements.length; i++) {
    titles.push(titleElements[i].textContent);
    /* tiles[i] */
    /*  for (var j = 0; j < titles.length; j++) {
         labels[j].textContent = titles[j];
     } */
}


console.log(labels);