'use strict';

export default function (method, url, callback) {
    const Http = new XMLHttpRequest();
    Http.open(method.toUpperCase(), url);
    Http.send();

    Http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            callback(this.responseText);
        }
    }
}
