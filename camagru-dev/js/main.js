// function openTab(tab)
// {
//     var i, tabs_c, tabs_l, the_c;
    
//     tabs_c = document.getElementsByClassName('tabcontent');
//     for (i = 0; i < tabs_c.length; i++)
//     {
//         tabs_c[i].style.display = "none";
//     }
//     the_c = document.getElementById(tab);
//     the_c.style.display = "block";
    
// }

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
