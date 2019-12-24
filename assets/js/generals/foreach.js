'use strict';

export default function (iterable, elementFunction) {
    for (let key in iterable) {
        if (iterable.hasOwnProperty(key)) {
            elementFunction(iterable[key], key);
        }
    }
}
