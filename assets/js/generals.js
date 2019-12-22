'use strict';

function foreach(iterable, elementFunction) {
    for (let key in iterable) {
        if (iterable.hasOwnProperty(key)) {
            elementFunction(iterable[key], key);
        }
    }
}

function animate(element, property, from, to, unitsTemplate, time) {
    let speed = (to - from) / time;
    let current = from;
    let interval = 10;
    let handle = window.setInterval(
        () => {
            current += speed * interval;
            element.style[property] = unitsTemplate.replace('$', current.toString());
        },
        interval
    );
    window.setTimeout(() => clearInterval(handle), time);
}

function ajax(url, callback) {
    const Http = new XMLHttpRequest();
    Http.open("GET", url);
    Http.send();

    Http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            callback(this.responseText);
        }
    }
}
