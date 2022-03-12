let projects = document.querySelectorAll(".project-js");

/*create cookie*/
function writeCookie(name,value,days) {
  var date, expires;
  if (days) {
    date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    expires = "; expires=" + date.toGMTString();
  }else{
    expires = "";
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
} 


/*selected project is created as a cookie*/
if(projects){
  projects.forEach(function(div, index){
    div.onclick = function(){
      window.location="dashboard.php";
      let projectOpened=index-1;
      writeCookie('sessionOpened', projectOpened, 3);
      let projectOpenedTest = getCookie('sessionOpened');
      console.log(projectOpenedTest);
    }
  })
}


/*make dashboard images dragable*/
let elements = document.getElementsByName("dashboardImg");
numberElements = elements.length;

while(numberElements !== 0){
    numberElements--;
    dragElement(elements[numberElements], numberElements);
    /*resizeElement(elements[numberElements], numberElements)*/
}

function dragElement(element, num){
    let pos1=0, pos2=0, pos3=0, pos4=0;
    if(document.getElementById(element.id + "img")){      /*make image dragable in div Id*/
        document.getElementById(element.id + "img").onmousedown = dragMouseDown;
      }else{      /*makes the div movable from anywhere inside*/
        element.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e){
        e=e || window.event;
        e.preventDefault();
        
        /*get mouse position*/
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;

        /*call function whenever the cursor moves*/
        document.onmousemove = elementDrag;
    }

    function elementDrag(e){
        e=e || window.event;
        e.preventDefault();

        /*get new mouse position*/
        pos1 = pos3-e.clientX;
        pos2 = pos4-e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;

        /*set elements new postition*/
        element.style.top = (element.offsetTop-pos2)+"px";
        element.style.left = (element.offsetLeft-pos1)+"px";

        /*set image location session*/
        let top=element.style.top, left=element.style.left;
        writeCookie("imageTop"+num, top, 1);
        writeCookie("imageLeft"+num, left, 1);
        imageTopTest = getCookie("imageTop"+num), imageLeftTest = getCookie("imageLeft"+num);
    }

    function closeDragElement(){
        /*stop moving element once mouse stops moving*/
        document.onmouseup = null;
        document.onmousemove = null;
        window.location="../officialNewtwork/includes/dashboard.inc.php";
        console.log("moved");
      }
}


