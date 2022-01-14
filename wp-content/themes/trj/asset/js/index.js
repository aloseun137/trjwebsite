(function() {
  const ham = document.querySelector('.hamburger');
  const firstSpan = document.querySelector('.hamburger span:nth-child(1)');
  const secSpan = document.querySelector('.hamburger span:nth-child(2)');
  const thirdSpan = document.querySelector('.hamburger span:nth-child(3)');
  const mobileMenu = document.querySelector('.mobile-menu');

  if(ham) {
    ham.addEventListener('click', function(){
      mobileMenu.classList.toggle('open');
      ham.classList.toggle('open');
      firstSpan.classList.toggle('fl');
      secSpan.classList.toggle('sl');
      thirdSpan.classList.toggle('tl');
    });   
  }

}())

//Add class to hero text

const intro = document.querySelector('.intro');

if(intro) {
  intro.classList.add('go');
}

/* Stick Nav */

const sticky = () => {
  const navbar =  document.querySelector('.trj-header');
  const stickyOff = navbar.offsetTop;

  if(window.pageYOffset > stickyOff || window.pageYOffset > 0) {
    navbar.classList.add('sticky');
  } else {
    navbar.classList.remove('sticky');
  }
}

window.onscroll = sticky;

/* Radio Button */
const amountCheck = document.querySelectorAll('.amount');
const category = document.querySelectorAll('.cat_text');

if(amountCheck) {
  for (amount in amountCheck) {
    console.log(amount)
  }
}



