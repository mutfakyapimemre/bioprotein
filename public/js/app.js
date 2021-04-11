$( document ).ready( function () {
    $( "select" ).niceSelect();
    /* JS inside the modal */
    initPhotoSwipeFromDOM( '.categories-slider' );
    initPhotoSwipeFromDOM( '.gallery-slider' );
    new Swiper( ".about-slider", {
        loop: !0,
        speed: 750,
        spaceBetween: 30,
        slidesPerView: 1,
        effect: "slide",
        parallax: !0,
        autoplay: {
            delay: 2500,
            disableOnInteraction: !1
        },
        navigation: {
            nextEl: ".about-slider-next",
            prevEl: ".about-slider-prev"
        },
        pagination: {
            el: ".swiper-pagination",
            type: "bullets",
            clickable: "true"
        },
        preloadImages: !1,
        lazy: !0
    } )
    $( document ).on( "click", ".makeOffer", function ( e ) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let url = $( this ).data( "url" );
        let formData = new FormData( document.getElementById( "offerform" ) );
        createAjax( url, formData, function () {
            $( "input[name='phone']" ).val( null );
            $( "input[name='email']" ).val( null );
            $( "input[name='full_name']" ).val( null );
            $( "input[name='message']" ).val( null );
        } );
    } );
    $( document ).on( "click", ".btnSubmitForm", function ( e ) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let url = $( this ).data( "url" );
        let formData = new FormData( document.getElementById( "contact-form" ) );
        createAjax( url, formData, function () {
            $( "#contact-form" )[ 0 ].reset();
        } );
    } );
    /* Tooltip */
    $( 'body' ).tooltip( {
        selector: '[data-toggle="tooltip"]',
        trigger: 'hover',
        container: 'body',
        placement: 'top',
        boundary: 'window',
    } ).on( 'click mousedown mouseup', '[data-toggle="tooltip"]', function () {
        $( '[data-toggle="tooltip"]' ).tooltip( 'dispose' );
    } );
    /* Tooltip */
    /*-----  Preloader
	---------------------------------*/
    $( window ).on( 'load', function () {
        $( '#preloader' ).delay( 250 ).fadeOut( 'slow' )
        $( 'body' ).delay( 250 ).css( {
            'overflow': 'visible'
        } );
    } );
} );

/* Functions */

function createAjax( url, formData, successFnc = function () {}, errorFnc = function () {} ) {
    $.ajax( {
        type: "POST",
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "JSON"
    } ).done( function ( response ) {
        if ( response.success ) {
            iziToast.success( {
                title: response.title,
                message: response.message,
                position: "topCenter",
                displayMode: 'once',
            } );
            successFnc( response );
            if ( response.redirect !== null && response.redirect !== "" && response.redirect !== undefined ) {
                setTimeout( function () {
                    window.location.href = response.redirect;
                }, 2000 );
            }
        } else {
            iziToast.error( {
                title: response.title,
                message: response.message,
                position: "topCenter",
                displayMode: 'once',
            } );
            errorFnc( response );
            if ( response.redirect !== null && response.redirect !== "" && response.redirect !== undefined ) {
                setTimeout( function () {
                    window.location.href = response.redirect;
                }, 2000 );
            }
        }
    } );
}

function createModal( modalClass = null, modalTitle = null, modalSubTitle = null, width = 600, bodyOverflow = true, padding = "20px", radius = 0, headerColor = "#e20e17", background = "#fff", zindex = 1040, onOpening = function () {}, onOpened = function () {}, onClosing = function () {}, onClosed = function () {}, afterRender = function () {}, onFullScreen = function () {}, onResize = function () {}, fullscreen = true, openFullscreen = false, closeOnEscape = true, closeButton = true, overlayClose = false, autoOpen = 0 ) {
    if ( modalClass !== "" || modalClass !== null ) {
        $( modalClass ).iziModal( {
            title: modalTitle,
            subtitle: modalSubTitle,
            headerColor: headerColor,
            background: background,
            width: width,
            zindex: zindex,
            fullscreen: fullscreen,
            openFullscreen: openFullscreen,
            closeOnEscape: closeOnEscape,
            closeButton: closeButton,
            overlayClose: overlayClose,
            autoOpen: autoOpen,
            padding: padding,
            bodyOverflow: bodyOverflow,
            radius: radius,
            onFullScreen: onFullScreen,
            onResize: onResize,
            onOpening: onOpening,
            onOpened: onOpened,
            onClosing: onClosing,
            onClosed: onClosed,
            afterRender: afterRender
        } );
    }
}

function openModal( modalClass = null, event = function () {} ) {
    $( modalClass ).iziModal( 'open', event );
}

function closeModal( modalClass = null, event = function () {} ) {
    $( modalClass ).iziModal( 'close', event );
}

function setCookie( name, value, days ) {
    let expires;

    if ( days ) {
        let date = new Date();
        date.setTime( date.getTime() + ( days * 24 * 60 * 60 * 1000 ) );
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent( name ) + "=" + encodeURIComponent( value ) + expires + "; path=/";
}

function getCookie( name ) {
    let nameEQ = encodeURIComponent( name ) + "=";
    let ca = document.cookie.split( ';' );
    for ( let i = 0; i < ca.length; i++ ) {
        let c = ca[ i ];
        while ( c.charAt( 0 ) === ' ' )
            c = c.substring( 1, c.length );
        if ( c.indexOf( nameEQ ) === 0 )
            return decodeURIComponent( c.substring( nameEQ.length, c.length ) );
    }
    return null;
}

function deleteCookie( name ) {
    setCookie( name, "", -1 );
}

var timestamp = function () {
    var timeIndex = 0;
    var shifts = [ 35, 60, 60 * 3, 60 * 60 * 2, 60 * 60 * 25, 60 * 60 * 24 * 4, 60 * 60 * 24 * 10 ];
    var now = new Date();
    var shift = shifts[ timeIndex++ ] || 0;
    var date = new Date( now - shift * 1000 );
    return date.getTime() / 1000;
};
var changeSkin = function ( skin ) {
    location.href = location.href.split( '#' )[ 0 ].split( '?' )[ 0 ] + '?skin=' + skin;
};
var getCurrentSkin = function () {
    var header = document.getElementById( 'header' );
    var skin = location.href.split( 'skin=' )[ 1 ];
    if ( !skin ) {
        skin = 'Snapgram';
    }
    if ( skin.indexOf( '#' ) !== -1 ) {
        skin = skin.split( '#' )[ 0 ];
    }
    var skins = {
        Snapgram: {
            avatars: true,
            list: false,
            autoFullScreen: false,
            cubeEffect: true,
            paginationArrows: false
        },
        VemDeZAP: {
            avatars: false,
            list: true,
            autoFullScreen: false,
            cubeEffect: false,
            paginationArrows: true
        },
        FaceSnap: {
            avatars: true,
            list: false,
            autoFullScreen: true,
            cubeEffect: false,
            paginationArrows: true
        },
        Snapssenger: {
            avatars: false,
            list: false,
            autoFullScreen: false,
            cubeEffect: false,
            paginationArrows: false
        }
    };
    var el = document.querySelectorAll( '#skin option' );
    var total = el.length;
    for ( var i = 0; i < total; i++ ) {
        var what = skin == el[ i ].value ? true : false;
        if ( what ) {
            el[ i ].setAttribute( 'selected', 'selected' );
            header.innerHTML = skin;
            header.className = skin;
        } else {
            el[ i ].removeAttribute( 'selected' );
        }
    }
    return {
        name: skin,
        params: skins[ skin ]
    };
};


function initPhotoSwipeFromDOM( gallerySelector ) {

    // parse slide data (url, title, size ...) from DOM elements
    // (children of gallerySelector)
    let parseThumbnailElements = function ( el ) {
        let thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for ( let i = 0; i < numNodes; i++ ) {

            figureEl = thumbElements[ i ]; // <figure> element

            // include only element nodes
            if ( figureEl.nodeType !== 1 ) {
                continue;
            }

            linkEl = figureEl.children[ 0 ]; // <a> element

            size = linkEl.getAttribute( 'data-size' ).split( 'x' );

            // create slide object
            item = {
                src: linkEl.getAttribute( 'href' ),
                w: parseInt( size[ 0 ], 10 ),
                h: parseInt( size[ 1 ], 10 )
            };



            if ( figureEl.children.length > 1 ) {
                // <figcaption> content
                item.title = figureEl.children[ 1 ].innerHTML;
            }

            if ( linkEl.children.length > 0 ) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[ 0 ].getAttribute( 'src' );
            }

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push( item );
        }

        return items;
    };

    // find nearest parent element
    let closest = function closest( el, fn ) {
        return el && ( fn( el ) ? el : closest( el.parentNode, fn ) );
    };

    // triggers when user clicks on thumbnail
    let onThumbnailsClick = function ( e ) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        let eTarget = e.target || e.srcElement;

        // find root element of slide
        let clickedListItem = closest( eTarget, function ( el ) {
            return ( el.tagName && el.tagName.toUpperCase() === 'FIGURE' );
        } );

        if ( !clickedListItem ) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        let clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for ( let i = 0; i < numChildNodes; i++ ) {
            if ( childNodes[ i ].nodeType !== 1 ) {
                continue;
            }

            if ( childNodes[ i ] === clickedListItem ) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if ( index >= 0 ) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    let photoswipeParseHash = function () {
        let hash = window.location.hash.substring( 1 ),
            params = {};

        if ( hash.length < 5 ) {
            return params;
        }

        let vars = hash.split( '&' );
        for ( let i = 0; i < vars.length; i++ ) {
            if ( !vars[ i ] ) {
                continue;
            }
            let pair = vars[ i ].split( '=' );
            if ( pair.length < 2 ) {
                continue;
            }
            params[ pair[ 0 ] ] = pair[ 1 ];
        }

        if ( params.gid ) {
            params.gid = parseInt( params.gid, 10 );
        }

        return params;
    };

    let openPhotoSwipe = function ( index, galleryElement, disableAnimation, fromURL ) {
        let pswpElement = document.querySelectorAll( '.pswp' )[ 0 ],
            gallery,
            options,
            items;

        items = parseThumbnailElements( galleryElement );

        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute( 'data-pswp-uid' ),

            getThumbBoundsFn: function ( index ) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                let thumbnail = items[ index ].el.getElementsByTagName( 'img' )[ 0 ], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();

                return {
                    x: rect.left,
                    y: rect.top + pageYScroll,
                    w: rect.width
                };
            }

        };

        // PhotoSwipe opened from URL
        if ( fromURL ) {
            if ( options.galleryPIDs ) {
                // parse real index when custom PIDs are used
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for ( let j = 0; j < items.length; j++ ) {
                    if ( items[ j ].pid === index ) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt( index, 10 ) - 1;
            }
        } else {
            options.index = parseInt( index, 10 );
        }

        // exit if index not found
        if ( isNaN( options.index ) ) {
            return;
        }

        if ( disableAnimation ) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
        gallery.init();
    };

    // loop through all gallery elements and bind events
    let galleryElements = document.querySelectorAll( gallerySelector );

    for ( let i = 0, l = galleryElements.length; i < l; i++ ) {
        galleryElements[ i ].setAttribute( 'data-pswp-uid', i + 1 );
        galleryElements[ i ].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    let hashData = photoswipeParseHash();
    if ( hashData.pid && hashData.gid ) {
        openPhotoSwipe( hashData.pid, galleryElements[ hashData.gid - 1 ], true, true );
    }
};