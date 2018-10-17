'use strict'

// iterate over component
// TODO: init via closure lib
// TODO: init once for document context
// TODO: domReady for more secure init?
var context = document;
Array.prototype.forEach.call( context.querySelectorAll('.wdiv-team-wrapper') , function (teamWrapper) {

    // TODO: callbacks on filter
    // TODO: init List.js on content
    // TODO: single filter function
    // TODO: multifilter function

    console.log(teamWrapper);

});
