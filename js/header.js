let burger = document.querySelector('.header__burger');
let menu = document.querySelector('.header__burger-menu');
let bdy = document.querySelector('body');
let searchBtn = document.querySelector('.header__search-btn');
let search = document.querySelector(".header__search");
let headerLogo = document.querySelector('.header__logo');
let headerMainMenu = document.querySelector('.header__main-menu');
let searchInput = document.querySelector('.search-input');
let cartBtn = document.querySelector('.header__cart-btn');

burger.addEventListener('click', function (){
	burger.classList.toggle('active');
	menu.classList.toggle('active');
	bdy.classList.toggle('lock');
});


searchBtn.addEventListener('click', onSearch);

bdy.addEventListener('click', bdyClick, this);

function bdyClick(target){
	if(target.target != searchInput && target.target != searchBtn.firstElementChild) {
		if(search.classList.contains('active')){
			onSearch();
		}
	}
}


function onSearch () {
	search.classList.toggle('active');
	headerLogo.classList.toggle('active');
	headerMainMenu.classList.toggle('active');
	searchBtn.classList.toggle('hide');
	cartBtn.classList.toggle('hide');
}