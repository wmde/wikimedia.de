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

    // simple one-value filter
    var filter = function(list, value) {
        // no value means: clear filter
        if (typeof value === "undefined") {
            // reset filtering via native List.js function
            list.filter()
            // remove filtered attribute
            teamWrapper.classList.remove('js-filtered');
            teamWrapper.removeAttribute('data-filtered-by');
            // done!
            return;
        }

        // we have a value = filter
        list.filter(function(item) {
            // filter for items
            if ( value === item.values()['group-id'] ) {
               return true;
            } else {
               return false;
            }
        });

        teamWrapper.classList.add('js-filtered');
        teamWrapper.setAttribute('data-filtered-by',value);
    }

    var inputFilters = context.querySelectorAll('.wdiv-radio-filter input');

    // TODO: initial run if filters are already checked in markup
    Array.prototype.forEach.call( inputFilters , function( inputFilter ){
        inputFilter.addEventListener('change', function (change) {

            var value = change.target.value;

            if (!change.target.checked) { return; }

            // input was selected = filter list
            filter(teamList, value);

        });
    });

    Array.prototype.forEach.call( context.querySelectorAll('.wdiv-filter-reset') , function (button) {

        button.addEventListener('click', function (change) {
            // remove checked attribute
            Array.prototype.forEach.call( inputFilters , function( inputFilter ){
                inputFilter.checked = false;
            });

            // reset filtering = don't pass value
            filter(teamList);
        });

    });

});
