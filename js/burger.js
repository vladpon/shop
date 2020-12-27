let burger = document.querySelector('.header__burger');
let menu = document.querySelector('.header__menu');
let bdy = document.querySelector('body');

burger.addEventListener('click', function (){
	burger.classList.toggle('active');
	menu.classList.toggle('active');
	bdy.classList.toggle('lock');
});


