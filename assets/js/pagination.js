'use strict';

import ajax from "./generals/ajax";
import $ from 'jquery';
import updateButtons from "./cart";

$('.page-item').on('click', function () {
    let pageNr = $(this).data('page-nr');
    if (pageNr) {
        loadPage(pageNr);
        return false;
    }
});

function loadPage(pageNr) {
    ajax("post", "/page/" + pageNr, response => {
        document.querySelector('#products').innerHTML = response;
        updateButtons();
    });
    ajax("post", "/pages/" + pageNr, response => {
        $("#pages").html(response);
    });
}
