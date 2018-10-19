'use strict'

// iterate over component
// TODO: init via closure lib
// TODO: init once for document context
// TODO: domReady for more secure init?
var context = document;
Array.prototype.forEach.call( context.querySelectorAll('.wdiv-topics-wrapper') , function (topicsWrapper) {

    // init List.js object
    var topicList = new List(topicsWrapper, {
        'listClass' : 'wdiv-topic-header',
        'valueNames' : [ {
            data: [ 'topic-id' ]
        } ]
    });
    var projectList = new List(topicsWrapper, {
        'listClass' : 'wdiv-projects',
        'valueNames' : [ {
            data: [ 'topic-id' ]
        } ]
    });

    // simple one-value filter
    var filter = function(list, value) {
        // no value means: clear filter
        if (typeof value === "undefined") {
            // reset filtering via native List.js function
            list.filter()
            // remove filtered attribute
            list.list.classList.remove('js-filtered');
            // done!
            return;
        }

        // we have a value = filter
        list.filter(function(item) {
            // filter for items
            if ( value === item.values()['topic-id'] ) {
               return true;
            } else {
               return false;
            }
        });

        list.list.classList.add('js-filtered');
    }

    var inputFilters = context.querySelectorAll('.wdiv-topics-filter input');

    // TODO: initial run if filters are already checked in markup
    Array.prototype.forEach.call( inputFilters , function( inputFilter ){
        inputFilter.addEventListener('change', function (change) {

            var value = change.target.value;

            if (!change.target.checked) { return; }

            // input was selected = filter both lists
            filter(topicList, value);
            filter(projectList, value);

        });
    });

    Array.prototype.forEach.call( context.querySelectorAll('.wdiv-topics-filter-reset') , function (button) {

    button.addEventListener('click', function (change) {
        // remove checked attribute
        Array.prototype.forEach.call( inputFilters , function( inputFilter ){
            inputFilter.checked = false;
        });

        // reset filtering = don't pass value
        filter(topicList);
        filter(projectList);
    });

    });


});
