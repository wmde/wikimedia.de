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

});
