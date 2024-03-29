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
      let projectOpened=index;
      writeCookie('sessionOpened', projectOpened, 3);
      let projectOpenedTest = getCookie('sessionOpened');
      /*console.log(projectOpenedTest);*/
    }
  })
}

/*make div for elements dragable*/
const elements = document.getElementsByName("dashboardItem");
const btnVideoElements = document.getElementsByName("btnVideoElement");
const btnAudioElements = document.getElementsByName('btnAudioElement');
let isResizing = false;
let isPlayBtn = false;


/*btnVideo Paused or Playing*/
btnVideoElements.forEach(function(div){
  let btnVideoClass = div.classList.toString();
  let btnVideoNum = btnVideoClass.split("_")[1];
  div.addEventListener("mousedown", function(){
    btnVideoMouseDown(div, btnVideoNum);
  });

  let video = document.querySelector("[class='"+btnVideoNum+"'] video");
  video.addEventListener("ended", (event)=>{
    div.innerHTML = "&#9658";
  })
});
btnAudioElements.forEach(function(div){
  let btnAudioClass = div.classList.toString();
  let btnAudioNum = btnAudioClass.split("_")[1];
  div.addEventListener("mousedown", function(){
    btnAudioMouseDown(div, btnAudioNum);
  });

  let audio = document.querySelector("[class='"+btnAudioNum+"'] audio");
  audio.addEventListener("ended", (event) =>{
    div.innerHTML = "&#9658";
  })
  /*audio.innerHTML = "&#9658";*/
});

function btnVideoMouseDown(div, num){
  window.addEventListener("mouseup", btnVideoMouseUp);
  isPlayBtn = true;

  function btnVideoMouseUp(){
    video = document.querySelector("[class='"+num+"'] video");
    if(video.paused){
      div.innerHTML = "&#9646";
      video.play();
    }else if(!video.paused){
      div.innerHTML = "&#9658";
      video.pause();
    }

    isPlayBtn = false;
    window.removeEventListener("mouseup", btnVideoMouseUp);
  }
}
function btnAudioMouseDown(btn, num){
  window.addEventListener("mouseup", btnAudioMouseUp);
  isPlayBtn = true;
  /*console.log(btn);*/

  function btnAudioMouseUp(){
    audio = document.querySelector("[class='"+num+"'] audio");
    if(audio.paused){
      btn.innerHTML = "&#9646";
      audio.play();
    }else if(!audio.paused){
      btn.innerHTML = "&#9658";
      audio.pause();
    }
    isPlayBtn = false;
    window.removeEventListener("mouseup", btnAudioMouseUp);
  }
}


/*Drag elements*/
if(elements){
  elements.forEach(function(div, index){
    div.addEventListener("mouseover", function(){
      f1Re(div, index);
    })
    div.addEventListener("mousedown", function(){
      /*check if vidBtnElement is not being pressed*/
      if(!isResizing && !isPlayBtn){
        f1(div, index);
      }
    });
  })
}

function f1(e, num){
  /*console.log("drag");*/
  window.addEventListener("mouseup", f3);
  window.addEventListener("mousemove", f2);

  /*get mouse position*/
  let prevX = e.clientX;
  let prevY = e.clientY;

  function f2(e){
    if(!isResizing && !isPlayBtn){
      /*find new mouse position*/
      let newX = prevX-e.clientX;
      let newY = prevY-e.clientY;

      /*find current position of element*/
      const domRect = elements[num].getBoundingClientRect();

      /*set new position*/
      elements[num].style.left = domRect.left-newX+"px";
      elements[num].style.top = domRect.top-newY+"px";
      
      cookieLeft = domRect.left-newX+"px";
      cookieTop = domRect.top-newY+"px";

      prevX = e.clientX;
      prevY = e.clientY;
    }
  }

  function f3(){
    /*console.log(cookieLeft);*/

    writeCookie(getCookie('sessionOpened')+"elX"+num, cookieLeft, 1);
    writeCookie(getCookie('sessionOpened')+"elY"+num, cookieTop, 1);
    window.removeEventListener("mousemove", f2);
    window.removeEventListener("mouseup", f3);
    /*console.log("Top: "+cookieTop+" | Left: "+cookieLeft);*/
    //window.location= "../officialNewtwork/includes/dashboard.inc.php";
  }
}


/*resizing function*/
function f1Re(e, num){
  let resizers = elements[num].querySelectorAll(".resizer");
  let currentResizer;
  let cookieWidth;
  let cookieHeight;
  let cookieTop = getCookie(getCookie('sessionOpened')+"elY"+num);
  let cookieLeft = getCookie(getCookie('sessionOpened')+"elX"+num);
  for(let resizer of resizers){
    resizer.addEventListener("mousedown", f1Re2);

    function f1Re2(e){
      isResizing = true;
      currentResizer = e.target;

      let prevX = e.clientX;
      let prevY = e.clientY;

      window.addEventListener("mousemove", f2Re2);
      window.addEventListener("mouseup", f3Re2);

      function f2Re2(e){
        const domRect = elements[num].getBoundingClientRect();

        /*dragging for corners*/
        if(currentResizer.classList.contains("se")){
          elements[num].style.width = domRect.width-(prevX-e.clientX)+"px";
          elements[num].style.height = domRect.height-(prevY-e.clientY)+"px";
          cookieWidth = domRect.width-(prevX-e.clientX)+"px";
          cookieHeight = domRect.height-(prevY-e.clientY)+"px";
        }
        else if(currentResizer.classList.contains("sw")){
          elements[num].style.width = domRect.width+(prevX-e.clientX)+"px";
          elements[num].style.height = domRect.height-(prevY-e.clientY)+"px";
          elements[num].style.left = domRect.left-(prevX-e.clientX)+"px";
          cookieWidth = domRect.width+(prevX-e.clientX)+"px";
          cookieHeight = domRect.height-(prevY-e.clientY)+"px";
          cookieLeft = domRect.left-(prevX-e.clientX)+"px";
        }
        else if(currentResizer.classList.contains("ne")){
          elements[num].style.width = domRect.width-(prevX-e.clientX)+"px";
          elements[num].style.height = domRect.height+(prevY-e.clientY)+"px";
          elements[num].style.top = domRect.top-(prevY-e.clientY)+"px";
          cookieWidth = domRect.width-(prevX-e.clientX)+"px";
          cookieHeight = domRect.height+(prevY-e.clientY)+"px";
          cookieTop = domRect.top-(prevY-e.clientY)+"px";
        }
        else if(currentResizer.classList.contains("nw")){
          elements[num].style.width = domRect.width+(prevX-e.clientX)+"px";
          elements[num].style.height = domRect.height+(prevY-e.clientY)+"px";
          elements[num].style.top = domRect.top-(prevY-e.clientY)+"px";
          elements[num].style.left = domRect.left-(prevX-e.clientX)+"px";
          cookieWidth = domRect.width+(prevX-e.clientX)+"px";
          cookieHeight = domRect.height+(prevY-e.clientY)+"px";
          cookieTop = domRect.top-(prevY-e.clientY)+"px";
          cookieLeft = domRect.left-(prevX-e.clientX)+"px";
        }

        /*set mouse to current position*/
        prevX = e.clientX;
        prevY = e.clientY;
        /*console.log("testing one: "+cookieTop+" | testing two: "+cookieLeft);*/
      }

      function f3Re2(){
        writeCookie(getCookie('sessionOpened')+"resizeWidth"+num, cookieWidth, 1);
        writeCookie(getCookie('sessionOpened')+"resizeHeight"+num, cookieHeight, 1);
        /*
        writeCookie("elY"+num, cookieTop, 1);
        writeCookie("elX"+num, cookieLeft, 1);
        */

        if(cookieTop){
          writeCookie(getCookie('sessionOpened')+"elY"+num, cookieTop, 1);
        }
        if(cookieLeft){
          writeCookie(getCookie('sessionOpened')+"elX"+num, cookieLeft, 1);
        }
        /*console.log("testing cookie: "+cookieTop+" | testing cookie2: "+cookieLeft);*/
        
        /*console.log("Top: "+getCookie("elY"+num)+" | Left: "+getCookie("elX"+num)+" | Width: "+getCookie("resizeWidth"+num)+" | Height: "+getCookie("resizeHeight"+num));*/

        /*window.location = "../officialNewtwork/includes/dashboard.inc.php";*/
        window.removeEventListener("mousemove", f2Re2);
        window.removeEventListener("mouseup", f3Re2);
        isResizing = false;
        /*console.log(isResizing+"2");*/
      }
    }
  }
}

