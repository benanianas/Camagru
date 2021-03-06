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
    delete_btn = document.getElementById("del-btn"),
    rm_btn = document.getElementsByClassName("rm-btn"),
    sidebar = document.getElementById("images");

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

function ifImage(finput)
{
    var image = new Image();

    image.onerror = function(){
        return(false);
    };
    image.onload = function() {
        return(true);
    };

    image.src = URL.createObjectURL(finput); 
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
        xhr.send("photo="+canvasdata+"&selected="+selected.value+"&camera=1&token="+csrfToken);
    else
    {
        var finput = pic.files[0];
        var image = new Image();

        image.onload = function() {
            var allowed = ["image/png", "image/jpeg", "image/jpg"];
            if(allowed.includes(finput.type) == true && finput.size < 1000000)
            {
                
                msg.style.display = "none";
                // console.log("Good!");
                // console.log(finput);
                var reader = new FileReader();
                reader.addEventListener("load", function(){
        
                    // console.log(reader.result);
                    xhr.send("photo="+reader.result+"&selected="+selected2.value+"&camera=0&token="+csrfToken);
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
        };
        image.onerror = function(){
            msg.style.display = "block";
            msg.innerHTML = "You cannot upload files of this type!";
        };
        image.src = URL.createObjectURL(finput); 
        
        
    }
}


function changeEmoji()
{
    var react = document.getElementById('react').value;
    var i = 0;
    while(i < 10)
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
    if(react == 'mina3ima')
        emoji[6].style.display = "block";
    if(react == 'niba')
        emoji[7].style.display = "block";
    if(react == 'raghibamine')
        emoji[8].style.display = "block";
    if(react == 'tasir')
        emoji[9].style.display = "block";
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

    var xhr = new XMLHttpRequest();

    // xhr.onreadystatechange = function()
    // {
    //     if(this.readyState == 4 && this.status == 200)
    //     {
    //         console.log(this.responseText);
    //     }
    // };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("post=0&imgpath="+document.getElementById("rimg").src+"&token="+csrfToken);
}

function postIt()
{
    var imglink = document.getElementById("rimg").src;
    modal.style.display = "none";
    
    var xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            postToSidebar(this.responseText);
        }
    };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("post=1&imgpath="+imglink+"&token="+csrfToken);
}

function postToSidebar(img)
{
    var cont = document.createElement("div");
    cont.innerHTML = '<div id="img-container"><img src="'+img+
    '"><button class="rm-btn button is-danger" type="button">Delete</button></div>';
    sidebar.insertBefore(cont, sidebar.firstChild);
    
    Array.prototype.forEach.call(rm_btn, function(element) {
        element.onclick = function(){
            document.getElementById("rm-modal").style.display = "block";
            document.getElementById("close1").onclick = function(){document.getElementById("rm-modal").style.display = "none";};
            document.getElementById("cancel-btn").onclick = function(){document.getElementById("rm-modal").style.display = "none";};
            document.getElementById("delete-btn").onclick = function(){removePost(element);};

        };
    });
    document.getElementById("emptymsg").style.display = "none";
}

Array.prototype.forEach.call(rm_btn, function(element) {
    element.onclick = function(){
        document.getElementById("rm-modal").style.display = "block";
        document.getElementById("close1").onclick = function(){document.getElementById("rm-modal").style.display = "none";};
        document.getElementById("cancel-btn").onclick = function(){document.getElementById("rm-modal").style.display = "none";};
        document.getElementById("delete-btn").onclick = function(){removePost(element);};
    };
});

function removePost(elm)
{
    document.getElementById("rm-modal").style.display = "none";
    elm.parentElement.style.display ="none";

    // alert(elm.previousSibling.src);
    //i need to use ajax here


    var xhr = new XMLHttpRequest();

    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("delete=1&imgpath="+elm.previousSibling.src+"&token="+csrfToken);

}