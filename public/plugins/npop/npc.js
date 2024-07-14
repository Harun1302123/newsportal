// var __service_provider_host = 'http://127.0.0.1:3087';
var __service_provider_host = '//polling.portal.gov.bd';

/**
 * Create function for load opinion poll
 */
function closeCommentSection(e){
    // document.getElementById('online_comment_black_overlay').remove();
    document.getElementById('online_comment_view').remove();
    document.body.style.cssText = 'overflow: auto';
}

// function checkMediaQuery() {
//     // If the inner width of the window is greater then 768px
//     if (window.innerWidth <= 480) {
//         document.getElementById("online_comment_view").style.cssText = 'position:fixed;left:5%;top:5%;background-color:#fff;z-index:10000;width:90%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
//     }else{
//         document.getElementById("online_comment_view").style.cssText = 'position:fixed;left:15%;top:10%;background-color:#fff;z-index:10000;width:70%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
//     }
// }

// Create a condition that targets viewports at 480px wide
// if(!mobOpMediaQuery)
const mobMediaQuery = window.matchMedia('(max-width: 480px)')
function handleMobileChange(e) {
    // Check if the media query is true
    if (e.matches) {
        // Then log the following message to the console
        document.getElementById("online_comment_view").style.cssText = 'position:fixed;left:0%;top:0%;background-color:#00000080;z-index:10000;width:100%;height:100%;overflow-y: auto;';
        document.getElementById("close_online_comment_view").style.cssText = 'position:absolute;width:30px;height:30px;line-height:30px;text-align:center;right:auto;left:-15px;top:15px;background-color:#fff;border-radius:50%;cursor:pointer;box-shadow:0 0 5px #000;z-index:5';
    }else{
        document.getElementById("online_comment_view").style.cssText = 'position:fixed;left:0%;top:0%;background-color:#00000080;z-index:10000;width:100%;height:100%;overflow-y: auto;';
        document.getElementById("close_online_comment_view").style.cssText = 'position:absolute;width:30px;height:30px;line-height:30px;text-align:center;left:auto;right:-15px;top:15px;background-color:#fff;border-radius:50%;cursor:pointer;box-shadow:0 0 5px #000;z-index:5';
    }
}

// Register event listener
mobMediaQuery.addListener(handleMobileChange)

// Add a listener for when the window resizes
// window.addEventListener('resize', checkMediaQuery);

async function loadCommentSection(e, comment_type_id=''){
    var __cur_location = window.location;
    console.log(__cur_location)
    var url = __service_provider_host + '/load-comment-component';
    var elm = document.createElement('div');
    elm.setAttribute('id','online_comment_view');

    document.body.style.cssText = 'overflow: hidden';

    /**
     * Call for data
     */

    elm.innerHTML = '<div style="position:relative;width:70%;left:15%;top:5%;box-shadow:0 0 15px #000;border-radius:5px;padding-bottom:15px;"><span id="close_online_comment_view" onclick="closeCommentSection(this)">x</span><object data="'+ url + '?req_from=' + __cur_location.host + '&path=' + __cur_location.pathname + (comment_type_id?'&type_id=' + comment_type_id:'') +'" width="100%" height="600" style="border-radius: 5px" /></div>';

    document.getElementById("onlineCommentBlock").appendChild(elm);
    document.getElementById("online_comment_view").style.cssText = 'position:fixed;left:0%;top:0%;background-color:#00000080;z-index:10000;overflow-y:scroll;width:100%;height:100%;';

    // Define the media query
    // const mobileMediaQuery = window.matchMedia('(max-width: 480px)')
    // if (mobileMediaQuery.matches) {
    //     document.getElementById("online_comment_view").style.cssText = 'position:fixed;left:5%;top:5%;background-color:#fff;z-index:10000;width:90%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
    // }
    // checkMediaQuery();
    // Initial check
    handleMobileChange(mobMediaQuery);

    document.getElementById("close_online_comment_view").style.cssText = 'position:absolute;width:30px;height:30px;line-height:30px;text-align:center;right:-10px;top:-10px;background-color:#fff;border-radius:50%;cursor:pointer;box-shadow:0 0 5px #000;z-index:5';

    /**
     * For black overlay
     */
    // var elm = document.createElement('div');
    // elm.setAttribute('id','online_comment_black_overlay');
    // document.getElementById("onlineCommentBlock").appendChild(elm);
    // document.getElementById("online_comment_black_overlay").style.cssText = 'position:fixed;left:0;top:0;background-color:#00000080;z-index:9999;width:100%;height:100%;';
}

/**
 * SVG FILES
 */
var comment_icon_svg = '<?xml version="1.0" encoding="UTF-8"?><svg viewBox="0 0 317.02 317.02" xmlns="http://www.w3.org/2000/svg"><g transform="translate(-6612.3 -3981.5)" data-name="Group 388"><path transform="translate(6612.3 3981.5)" d="m45 0h272.02v317.02h-272.02a45 45 0 0 1-45-45v-227.02a45 45 0 0 1 45-45z" fill="#39b54a" data-name="Rectangle 109"/><path d="m6844.1 4061h-139.64a26.511 26.511 0 0 0-26.48 26.48v85.459a26.508 26.508 0 0 0 26.386 26.48v38.781l55.73-38.78h84.005a26.51 26.51 0 0 0 26.479-26.483v-85.457a26.51 26.51 0 0 0-26.479-26.48zm-25.071 99.315h-89.5v-11.285h89.5zm0-24.076h-89.5v-11.285h89.5zm0-24.075h-89.5v-11.285h89.5z" fill="#fff" data-name="Path 1295"/></g></svg>';

/**
 * Create element
 */
var elm = document.createElement('div');
elm.style.cssText = 'position:relative; z-index: 9999'
elm.setAttribute("id", "onlineCommentBlock");
// elm.innerHTML = '<div id="widget_comment_icon" title="Comment" onclick="loadCommentSection(this)">'+ comment_icon_svg +'</div>';
elm.innerHTML = '<div id="widget_comment_icon" title="পোর্টাল উন্নয়নে আপনার মতামত দিন" onclick="loadCommentSection(this)"><img id="comment_widget_icon" src="'+ __service_provider_host +'/comment.gif" /></div>';
document.body.appendChild(elm);
// document.getElementById("widget_comment_icon").style.cssText = 'position:fixed;right:0;top:45%;width:45px;height:45px;padding:0;background-color:#fff;border-radius:6px 0 0 6px;cursor:pointer;z-index:9998';
document.getElementById("widget_comment_icon").style.cssText = 'border: 1px solid #2B962B; color:  #2B962B;position:fixed;right:0;top:268px;width:58px;padding:2px;background-color:#fff;border-radius:6px 0 0 6px;cursor:pointer;z-index:9998';
document.getElementById('comment_widget_icon').style.cssText = 'width: 100%; height: 100%; object-fit: contain';

/**
 * Create label
 */

var elem2 = document.createElement('label');
elem2.innerHTML = "মতামত";
document.getElementById('widget_comment_icon').appendChild(elem2);

/**
 * Accessibility
 */
var elem3 = document.createElement('label');
elem3.innerHTML = "কমেন্ট";
document.getElementById('accessibilityBar').appendChild(elem3);
 document.getElementById("#accessibilityBar").style.cssText = 'top:360px!important';
