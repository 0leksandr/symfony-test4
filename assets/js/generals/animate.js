'use strict';

export default function (element, property, from, to, unitsTemplate, time) {
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
