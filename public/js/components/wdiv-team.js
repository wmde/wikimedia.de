'use strict'

// iterate over component
// TODO: init via closure lib
// TODO: init once for document context
// TODO: domReady for more secure init?
var context = document;
Array.prototype.forEach.call( context.querySelectorAll('.wdiv-team-wrapper') , function (teamWrapper) {

    // init List.js object
    var teamList = new List(teamWrapper, {
        'listClass' : 'wdiv-team-content',
        'valueNames' : [ {
            data: [ 'group-id' ]
        } ]
    });

    // active filter lookup array
    var active = [];

    // filter against `active` array
    function filter() {
        teamList.filter(function(item) {
            // filter for items
            if ( active.indexOf( item.values()['group-id'] ) > -1 ) {
               return true;
            } else {
               return false;
            }
        });
    }

    var inputFilters = context.querySelectorAll('.wdiv-team-filter input');

    // TODO: initial run if filters are already checked in markup
    Array.prototype.forEach.call( inputFilters , function( inputFilter ){
        inputFilter.addEventListener('change', function (change) {

            var value = change.target.value;

            // Note: the following logic assumes unique values on all checkboxes
            switch (change.target.checked) {
                case true:
                    // add to filter
                    active.push(change.target.value);
                    break;
                case false:
                    // remove existing filter
                    if ( active.indexOf(value) > -1 ) {
                        active.splice(active.indexOf(value));
                    }
                    break;
            }

            filter();

        });
    });

});
