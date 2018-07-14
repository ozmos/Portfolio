! function addLabels() {
    const tiles = document.getElementsByClassName('project-tile');
    const titleElements = document.getElementsByClassName('project-title');
    const titles = [];

    for (let i = 0; i < titleElements.length; i++) {
        titles.push(titleElements[i].textContent);
        let labels = document.createElement('span');
        labels.classList.add('image-label');
        tiles[i].appendChild(labels);
        for (let j = 0; j < titles.length; j++) {
            tiles[j].lastChild.textContent = titles[j];
        }
    }
}();