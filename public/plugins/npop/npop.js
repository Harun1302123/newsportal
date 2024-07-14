// var __service_provider_host = 'http://127.0.0.1:3087';
var __service_provider_host = '//polling.portal.gov.bd';

/**
 * Create function for load opinion poll
 */
function closeOpinionPoll(e){
    document.getElementById('online_poll_black_overlay').remove();
    document.getElementById('online_poll_view').remove();
}

// function checkMediaQuery() {
//     // If the inner width of the window is greater then 768px
//     if (window.innerWidth <= 480) {
//         document.getElementById("online_poll_view").style.cssText = 'position:fixed;left:5%;top:5%;background-color:#fff;z-index:10000;width:90%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
//     }else{
//         document.getElementById("online_poll_view").style.cssText = 'position:fixed;left:15%;top:10%;background-color:#fff;z-index:10000;width:70%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
//     }
// }

// Create a condition that targets viewports at 480px wide
const mobOpMediaQuery = window.matchMedia('(max-width: 480px)')
function handleOpMobileChange(e) {
    // Check if the media query is true
    if (e.matches) {
        // Then log the following message to the console
        document.getElementById("online_poll_view").style.cssText = 'position:fixed;left:5%;top:20px;background-color:#fff;z-index:10000;width:90%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
        document.getElementById("close_online_poll_view").style.cssText = 'position:absolute;width:30px;height:30px;line-height:30px;text-align:center;left:-15px;top:15px;background-color:#fff;border-radius:50%;cursor:pointer;box-shadow:0 0 5px #000;z-index:5';
    }else{
        document.getElementById("online_poll_view").style.cssText = 'position:fixed;left:15%;top:5%;background-color:#fff;z-index:10000;width:70%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
        document.getElementById("close_online_poll_view").style.cssText = 'position:absolute;width:30px;height:30px;line-height:30px;text-align:center;right:-15px;top:15px;background-color:#fff;border-radius:50%;cursor:pointer;box-shadow:0 0 5px #000;z-index:5';
    }
}

// Register event listener
mobOpMediaQuery.addListener(handleOpMobileChange);

// Add a listener for when the window resizes
// window.addEventListener('resize', checkMediaQuery);

async function loadOpinionPoll(e, view_type=''){
    var __cur_location = window.location;
    console.log(__cur_location)
    var url = __service_provider_host + '/load-opinion-poll';

    if(view_type) url = __service_provider_host + '/load-polling-history';

    var elm = document.createElement('div');
    elm.setAttribute('id','online_poll_view');

    /**
     * Call for data
     */
    elm.innerHTML = '<span id="close_online_poll_view" onclick="closeOpinionPoll(this)">x</span><iframe src="'+ url + '?req_from=' + __cur_location.host +'" frameborder=0 allowtransparency=yes scrolling=no width="100%" height="500" style="height:500px !important" />';
    document.getElementById("onlinePollBlock").appendChild(elm);
    document.getElementById("online_poll_view").style.cssText = 'position:fixed;left:15%;top:10%;background-color:#fff;z-index:10000;width:70%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';

    // Define the media query
    // const mobileMediaQuery = window.matchMedia('(max-width: 480px)')
    // if (mobileMediaQuery.matches) {
    //     document.getElementById("online_poll_view").style.cssText = 'position:fixed;left:5%;top:5%;background-color:#fff;z-index:10000;width:90%;min-height:300px;box-shadow:0 0 15px #000;border-radius:5px;';
    // }
    // checkMediaQuery();
    // Initial check
    handleOpMobileChange(mobOpMediaQuery);

    // document.getElementById("close_online_poll_view").style.cssText = 'position:absolute;width:30px;height:30px;line-height:30px;text-align:center;right:-15px;top:15px;background-color:#fff;border-radius:50%;cursor:pointer;box-shadow:0 0 5px #000;z-index:5';

    /**
     * For black overlay
     */
    var elm = document.createElement('div');
    elm.setAttribute('id','online_poll_black_overlay');
    document.getElementById("onlinePollBlock").appendChild(elm);
    document.getElementById("online_poll_black_overlay").style.cssText = 'position:fixed;left:0;top:0;background-color:#00000080;z-index:9999;width:100%;height:100%;';
}

/**
 * SVG FILES
 */
var poll_icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 317.02 317.02"><g id="Group_392" data-name="Group 392" transform="translate(-6612.98 -4707.98)"><path id="Rectangle_111" data-name="Rectangle 111" d="M45,0H317.02a0,0,0,0,1,0,0V317.02a0,0,0,0,1,0,0H45a45,45,0,0,1-45-45V45A45,45,0,0,1,45,0Z" transform="translate(6612.98 4707.98)" fill="#39b54a"/><g id="Group_391" data-name="Group 391"><path id="Path_1300" data-name="Path 1300" d="M6722.6,4904.684a24.463,24.463,0,1,0-24.463-24.463A24.491,24.491,0,0,0,6722.6,4904.684Z" fill="#fff"/><path id="Path_1301" data-name="Path 1301" d="M6722.6,4845.973a34.255,34.255,0,0,1,32.444,45.225,30.958,30.958,0,0,1,12.567,24.9V4784H6722.6Z" fill="#fff"/><path id="Path_1302" data-name="Path 1302" d="M6797.941,4880.221a24.463,24.463,0,1,0,24.463-24.463A24.491,24.491,0,0,0,6797.941,4880.221Z" fill="#fff"/><path id="Path_1303" data-name="Path 1303" d="M6788.156,4880.221a34.287,34.287,0,0,1,34.248-34.248v-15.33h-45.011V4916.1a30.958,30.958,0,0,1,12.567-24.9A34.131,34.131,0,0,1,6788.156,4880.221Z" fill="#fff"/><path id="Path_1304" data-name="Path 1304" d="M6722.6,4914.469a34.21,34.21,0,0,1-27.227-13.5A21.131,21.131,0,0,0,6689,4916.1V4951h66.539v-34.9a21.126,21.126,0,0,0-6-14.759A34.205,34.205,0,0,1,6722.6,4914.469Z" fill="#fff"/><path id="Path_1305" data-name="Path 1305" d="M6849.631,4900.97a34.208,34.208,0,0,1-54.169.371,21.126,21.126,0,0,0-6,14.759V4951H6856v-34.9A21.131,21.131,0,0,0,6849.631,4900.97Z" fill="#fff"/></g></g></svg>';



/**
 * Create element
 */
var elm = document.createElement('div');
elm.style.cssText = 'position:relative; z-index: 9999'
elm.setAttribute("id", "onlinePollBlock");
// elm.innerHTML = '<div id="widget_polling_icon" title="Polling" onclick="loadOpinionPoll(this)">'+ poll_icon_svg +'</div>';
elm.innerHTML = '<div id="widget_polling_icon" title="মাত্র এক ক্লিকে ভোট দিন" onclick="loadOpinionPoll(this)"><img id="poll_widget_icon" src="'+ __service_provider_host +'/poll-icon.gif" /></div>';
document.body.appendChild(elm);
// document.getElementById("widget_polling_icon").style.cssText = 'position:fixed;right:0;top:35%;width:45px;height:45px;padding:0;background-color:#fff;border-radius:6px 0 0 6px;cursor:pointer;z-index:9998';
document.getElementById("widget_polling_icon").style.cssText = 'border: 1px solid #2B962B;color: #2B962B;position:fixed;right:0;top:175px;width:58px;padding:2px;background-color:#fff;border-radius:6px 0 0 6px;cursor:pointer;z-index:9998';
document.getElementById('poll_widget_icon').style.cssText = 'width: 100%; height: 100%; object-fit: contain';

/**
 * Create label
 */

var elem2 = document.createElement('label');
elem2.innerHTML = "পোলিং";
document.getElementById('widget_polling_icon').appendChild(elem2);

/**
 * Accessibility
 */
var elem3 = document.createElement('label');
elem3.innerHTML = "কমেন্ট";
document.getElementById('accessibilityBar').appendChild(elem3);
 document.getElementById("#accessibilityBar").style.cssText = 'top:360px!important';
