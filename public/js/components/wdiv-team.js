'use strict'

// iterate over component
// TODO: init via closure lib
// TODO: init once for document context
// TODO: domReady for more secure init?
var context = document;
Array.prototype.forEach.call( context.querySelectorAll('.wdiv-team-wrapper') , function (teamWrapper) {

    Array.prototype.forEach.call( context.querySelectorAll('.wdiv-team-filter input') , function( inputFilter ){
        inputFilter.addEventListener('change', function (change) {

            if (! change.target.checked) { return; }

            // log value if checked
            console.log(change.target.value);

        });
    });

    // TODO: init List.js on content
    // TODO: single filter function
    // TODO: multifilter function

});
