//Playlist youtube App
function youtubeapiplaylist (Y, pluginvariables){

    var initvalues = pluginvariables;
    var keyYoutube = initvalues.apikey;
    var playlistId = initvalues.idplaylist;
    var ApiYoutubeURL = "https://www.googleapis.com/youtube/v3/playlistItems";

    var options = {
        part: "snippet",
        key: keyYoutube,
        maxResults: 2000,
        playlistId: playlistId,
    };

    function loadVids() {
        $.getJSON(ApiYoutubeURL, options, function (data) {
            var id = data.items[0].snippet.resourceId.videoId;
            /* mainVid(id); */
            resultsLoop(data);

            $(".venobox").venobox({
                framewidth: "600px", // default: ''
                frameheight: "400px", // default: ''
                border: "0px", // default: '0'
                bgcolor: "#5dff5e", // default: '#fff'
                titleattr: "data-title", // default: 'title'
                numeratio: true, // default: false
                infinigall: true, // default: false
                share: ["facebook", "twitter", "download"], // default: []
            });
        });
    }

    loadVids();

    /* function mainVid(id) {
       $('#videoTestimonios').html(`
          <iframe width="560" height="315" src="https://www.youtube.com/embed/${id}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          `);
    } */

    function resultsLoop(data) {
        $.each(data.items, function (i, item) {
            var thumb = item.snippet.thumbnails.medium.url;
            var title = item.snippet.title;
            var description = item.snippet.description.substring(0, 300);
            var vid = item.snippet.resourceId.videoId;

            $("main").append(`
        <article class="youtubeArticle" data-key="${vid}">
        <a class="venobox" data-vbtype="video" href="https://www.youtube.com/watch?v=${vid}">
        <img src="${thumb}" alt="" />
        <div class="details-video">
            <h4>${title}</h4>
            <p>${description}</p>
        </div>
        </a>
       </article>
            
        `);
        });

        $("main").on("click", "article", function () {
            var id = $(this).attr("data-key");
            mainVid(id);
        });
    }


}


