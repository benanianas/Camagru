

function deleteNotif()
{
    var element = document.getElementsByClassName("changedpass");
    element[0].style.display = "none";
}


function changeNStatus(id, name)
{
    var val =  document.getElementById(id).checked;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send(name+"="+val );
}

// var pmodal = document.getElementById('profile-modal');
// var cls = document.getElementById('close');

// cls.addEventListener("click", function(){
//     pmodal.style.display = "none";
//   });
// function openModal()
// {
//     pmodal.style.display = "block";
// }

// function uplaodPPic()
// {
//     pmodal.style.display = "none";

//     var ppic = document.getElementById('p-photo');
//     var pmsg = document.getElementById('photo-err');
    
//     var pfinput = ppic.files[0];
//     // console.log(pfinput.type);

//     var allowed = ["image/png", "image/jpeg", "image/jpg"];
//     if(allowed.includes(pfinput.type) == true && pfinput.size < 1000000)
//     {
//         var xhr = new XMLHttpRequest();
        

//         xhr.onreadystatechange = function()
//         {
//             if(this.readyState == 4 && this.status == 200)
//             {
//                 document.getElementById("pimg").src = this.responseText;
//             }
//         };

//         xhr.open("POST", window.location.href , true);
//         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        
        
//         pmsg.style.display = "none";
//         var reader = new FileReader();
//         reader.addEventListener("load", function(){

//             // console.log(reader.result);
//             xhr.send("photo="+reader.result);
//         });
//         reader.readAsDataURL(pfinput);


//     }
//     else if(allowed.includes(pfinput.type) == false)
//     {
//         pmsg.style.display = "inline-block";
//         pmsg.innerHTML = "You cannot upload files of this type!";
//     }
//     else
//     {
//         pmsg.style.display = "inline-block";
//         pmsg.innerHTML = "Your file is too big!";
//     }
// }

// function removePPic(){

//     pmodal.style.display = "none";
    
//     var xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function()
//         {
//             if(this.readyState == 4 && this.status == 200)
//             {
//                 document.getElementById("pimg").src = this.responseText;
//             }
//         };
    
//     xhr.open("POST", window.location.href , true);
//     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
//     xhr.send("photo=0");

// }