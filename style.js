const imgPosition = document.querySelectorAll(".aspect-ratio-169 img")
const imgContainer = document.querySelector(".aspect-ratio-169")
const dotItem = document.querySelectorAll(".dot")
// console.log(imgPosition)
let imgNuber = imgPosition.length
let index = 0
imgPosition.forEach(function(image,index){
    image.style.left = index*100 + "%"
    dotItem[index].addEventListener("click", function(){
        slider (index)
    })
})
function imgSlider (){
    index++;
    console.log(index)
    if (index>=imgNuber) {index=0}
    imgContainer.style.left = "-" +index*100+"%"
    slider (index)
}
function slider (index) {
    imgContainer.style.left = "-" +index*100+"%"
    const dotActive = document.querySelector(".active")
    dotActive.classList.remove("active")
    dotItem[index].classList.add("active")
}

setInterval(imgSlider, 3000)

function openSlideMenu() {
  document.getElementById('side-menu').style.display = "inline"
  document.getElementById('icon').style.display = "none"
}

function closeSlideMenu() {
  document.getElementById('side-menu').style.display = "none"
}

const header = document.querySelector("header")
window.addEventListener("scroll",function() {
  x = this.window.pageYOffset
  if(x>0) {
    header.classList.add("sticky")
  }
  else {
    header.classList.remove("sticky")
  }
})
//--------------------------Menu-Slidebar-Catergory-------------------//

const itemslidebar = document.querySelectorAll(".category-left-li")
itemslidebar.forEach(function(menu,index){
  menu.addEventListener("click",function(){
    menu.classList.toggle("block")
  })
})

//--------------Product---------------//
const bigImg = document.querySelector(".product-content-left-big-img img")
const smallImg = document.querySelectorAll(".product-content-left-small-img img")
smallImg.forEach(function(imgItem,x){
  imgItem.addEventListener("click",function(){
    bigImg.src = imgItem.src
  })
})


const preserve = document.querySelector(".preserve")
const detail = document.querySelector(".detail")
if(preserve){
  preserve.addEventListener("click", function(){
    document.querySelector(".product-content-right-bottom-content-detail").style.display = "none"
    document.querySelector(".product-content-right-bottom-content-preserve").style.display = "block"
  })
}

if(detail){
  detail.addEventListener("click", function(){
    document.querySelector(".product-content-right-bottom-content-detail").style.display = "block"
    document.querySelector(".product-content-right-bottom-content-preserve").style.display = "none"
  })
}

const button = document.querySelector(".product-content-right-bottom-top")
if(button){
  button.addEventListener("click", function(){
    document.querySelector(".product-content-right-bottom-content-big").classList.toggle("activeB")
  })
}

//-----------Provin-District-----------//
