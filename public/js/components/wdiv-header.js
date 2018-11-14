'use strict'

// iterate over component
// TODO: init via closure lib
// TODO: init once for document context
// TODO: domReady for more secure init?

var context = document;
Array.prototype.forEach.call( context.querySelectorAll('.wdiv-header-nav') , function (navWrapper) {

    // TODO: get and write nav height in px for animation
    // TODO: possibly update height on resize events

    Array.prototype.forEach.call( navWrapper.querySelectorAll('.wdiv-nav-toggle') , function (button) {

        button.addEventListener('click', function (change) {
            // Some notes:
            // - `click` events may prove troublesome on native Android Webview
            // - referencing `navwrapper` from inside the event could bind the wrong wrapper

            // TODO: get parent element from inside click and parse for
            //       '.wdiv-header-nav .wdiv-nav-toggle' only

            // TODO: toggle() not supported by IE11
            navWrapper.classList.toggle('wdiv-js-toggled');

        });


    });

});
