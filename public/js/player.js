let player = videojs('video');
let viewLogged = false;
player.on('timeupdate', function(){
    if(Math.ceil((player.currentTime()/player.duration())*100) >= 85 && !viewLogged){
        console.log(player.currentSrc());
        axios.put(`/api/videos/${window.CURRENT_VIDEO}`).then((data)=>{
            console.log(data.data.views);
        })

        viewLogged = true;
    }
})