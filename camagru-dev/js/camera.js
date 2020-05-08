var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var emoji = document.getElementsByClassName('emoji');
var btn = document.getElementById('snap');
var camera = document.getElementById('takepic');
var ifcamera = document.getElementById('withcamera');
var selected = document.getElementById('react');
var check = 0;

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: {width: 640,height:480,} }).then(function(stream) {
        video.srcObject = stream;
        video.play();

        if(video)
            ifcamera.style.display = "inline-block";
    });
}


document.getElementById("snap").addEventListener("click", function() {
    context.drawImage(video,0, 0, 640,480,0,0,640,480);
    var canvasdata = canvas.toDataURL("image/png");
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
            console.log(this.responseText);
    };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("photo="+canvasdata+"&selected="+selected.value );
});

function changeEmoji()
{
    var react = document.getElementById('react').value;
    var i = 0;
    while(i < 6)
    {
        emoji[i].style.display = "none"; 
        i++;
    }
    if(react == 'none')
    {
        btn.disabled = true;
        return;
    }
    btn.disabled = false;
    if(react == 'like')
        emoji[0].style.display = "block";
    if(react == 'love')
        emoji[1].style.display = "block";
    if(react == 'haha')
        emoji[2].style.display = "block";
    if(react == 'sleepy')
        emoji[3].style.display = "block";
    if(react == 'sad')
        emoji[4].style.display = "block";
    if(react == 'angry')
        emoji[5].style.display = "block";
}

