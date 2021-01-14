let burger = document.querySelector('.header__burger');
let menu = document.querySelector('.header__burger-menu');
let bdy = document.querySelector('body');
let searchBtn = document.querySelector('.header__search-btn');
let search = document.querySelector(".header__search");
let headerLogo = document.querySelector('.header__logo');
let headerMainMenu = document.querySelector('.header__main-menu');

burger.addEventListener('click', function (){
	burger.classList.toggle('active');
	menu.classList.toggle('active');
	bdy.classList.toggle('lock');
});


searchBtn.addEventListener('click', function (){
	search.classList.toggle('active');
	headerLogo.classList.toggle('active');
	headerMainMenu.classList.toggle('active');
})