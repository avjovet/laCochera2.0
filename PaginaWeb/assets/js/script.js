const header = document.querySelector("[data-main-header]");
///const backTopBtn = document.querySelector("[data-back-top-btn]");

let lastScrollPos = 0;

const hideHeader = function () {
  const isScrollBottom = lastScrollPos < window.scrollY;
  if (isScrollBottom) {
    header.classList.add("hide");
  } else {
    header.classList.remove("hide");
  }

  lastScrollPos = window.scrollY;
}

window.addEventListener("scroll", function () {
  if (window.scrollY >= 50) {
    header.classList.add("active");
    //backTopBtn.classList.add("active");
    hideHeader();
  } else {
    header.classList.remove("active");
    //backTopBtn.classList.remove("active");
  }
});


//slider


//gotop button
window.onscroll = function(){
  if(document.documentElement.scrollTop > 100){
    document.querySelector('.go-top-container').classList.add('show');
  }else{
    document.querySelector('.go-top-container').classList.remove('show')
  }
};

document.querySelector('.go-top-container').addEventListener('click', () => (
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  })
));
