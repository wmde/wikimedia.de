'use strict'

// iterate over component
// TODO: init via closure lib
// TODO: init once for document context
// TODO: domReady for more secure init?
var context = document;
Array.prototype.forEach.call( context.querySelectorAll('.wdiv-team-wrapper') , function (teamWrapper) {

    // active filter lookup
    var active = [];

    Array.prototype.forEach.call( context.querySelectorAll('.wdiv-team-filter input') , function( inputFilter ){
        inputFilter.addEventListener('change', function (change) {

            // Note: this logic assumes unique values on all checkboxes
            var value = change.target.value;

            if (change.target.checked) {
                // option is checked: add to filter
                active.push(change.target.value);
                // that's all!
            } else {
                // option is unchecked: remove existing filter
                if ( active.indexOf(value) > -1 ) {
                    active.splice(active.indexOf(value));
            }

        });
    });

    // TODO: init List.js on content
    // TODO: single filter function
    // TODO: multifilter function

});
