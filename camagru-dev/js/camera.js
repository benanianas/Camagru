var video = document.getElementById('video'),
    canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d'),
    emoji = document.getElementsByClassName('emoji'),
    btn = document.getElementById('snap'),
    camera = document.getElementById('takepic'),
    ifcamera = document.getElementById('withcamera'),
    selected = document.getElementById('react'),
    selected2 = document.getElementById('react2'),
    pic = document.getElementById('up-pic'),
    upform = document.getElementById('up-form'),
    check = 0,
    msg = document.getElementById('err-msg'),
    camerr = document.getElementById('camera-err'),
    closem = document.getElementById("close"),
    modal = document.getElementById("modal"),
    post_btn = document.getElementById("post-btn"),
    delete_btn = document.getElementById("del-btn");

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: {width: 640,height:480,} }).then(function(stream) {
        video.srcObject = stream;
        video.play();

        if(video)
        {
            selected.disabled = false;
            camerr.style.display = "none";
        }
    });
}


function snapIt(camera)
{
    if (camera)
    {
        context.drawImage(video,0, 0, 640,480,0,0,640,480);
        var canvasdata = canvas.toDataURL("image/png");
    }
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            // console.log(this.responseText);
            document.getElementById("rimg").src = this.responseText;
            modal.style.display = "block";
        }
    };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    if(camera)
        xhr.send("photo="+canvasdata+"&selected="+selected.value+"&camera=1" );
    else
    {
        var finput = pic.files[0];
        var allowed = ["image/png", "image/jpeg", "image/jpg"];
        if(allowed.includes(finput.type) == true && finput.size < 1000000)
        {
            msg.style.display = "none";
            // console.log("Good!");
            var reader = new FileReader();
            reader.addEventListener("load", function(){
    
                // console.log(reader.result);
                xhr.send("photo="+reader.result+"&selected="+selected2.value+"&camera=0");
            });
            reader.readAsDataURL(finput);
        }
        else if(allowed.includes(finput.type) == false)
        {
            msg.style.display = "block";
            msg.innerHTML = "You cannot upload files of this type!";
        }
        else
        {
            msg.style.display = "block";
            msg.innerHTML = "Your file is too big!";
        }
    }
}


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

function enableBtn()
{
    var react = document.getElementById('react2').value;
    var btn2 = document.getElementById('send');
    var up = document.getElementById('up-pic');
    if(react == 'none' || !up.value)
    {
        btn2.disabled = true;
        return;
    }
    btn2.disabled = false;
    
}
closem.onclick = function(){deleteIt();};
delete_btn.onclick = function(){deleteIt();};
post_btn.onclick = function(){postIt();};

function deleteIt()
{
    modal.style.display = "none";
}

function postIt()
{
    modal.style.display = "none";
}

