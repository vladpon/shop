
// var cb = document.querySelectorAll('input[type="checkbox"][name="cat_id[]"][value="127"]');
// cb[0].checked = true;

function setParams (params)
{
	params.forEach((element)=>
	{
		var cb = document.querySelector('input[type="checkbox"][name="' + element[0] + '[]"][value="' + element[1] + '"]');
		cb.checked = true;
	})
}

function getGetParams () {
	let searchStr = window.location.search;
	let params = new Array();
	if(searchStr){
		searchStr = searchStr.slice(1, searchStr.length);
		let arr = searchStr.split('&');
		arr.forEach((element)=>
		{
			params.push(element.split('='));
		});
		console.log(params);
		return params;
	}
}




//var srch = document.location.search;

// function getParam ()
// {
// 	var params = new Array();
// 	if(srch)
// 		if(srch.indexOf('&') != -1){
// 			// params.push(srch.slice(1, srch.indexOf('&')));
// 		}
// 		return params;
// }



let arr = document.querySelectorAll(".filter__title");
let list = document.querySelectorAll(".filter__list");
let filterBtn = document.querySelector('#filter-btn');
let filter = document.querySelectorAll('.filter');
let closeFilter = document.querySelector('.filter__close-btn');
let cancelFilter = document.querySelector('.filter__cancel-btn');
let filterForm = document.getElementById('filterForm');

let catalogContent = document.querySelector('.catalog__content');
let upBtn = document.querySelector('.up-btn');
let ringCB = document.getElementById('ringCB');
let braceletCB = document.getElementById('braceletCB');
let chainCB = document.getElementById('chainCB');

let ringSizes = document.querySelector('.filter__size-ring');
let braceletSizes = document.querySelector('.filter__size-bracelet');
let chainSizes = document.querySelector('.filter__size-chain');


ringCB.addEventListener('change', () => {
	ringSizes.classList.toggle('active');
})
braceletCB.addEventListener('change', () => {
	braceletSizes.classList.toggle('active');
})
chainCB.addEventListener('change', () => {
	chainSizes.classList.toggle('active');
})

upBtn.addEventListener('click', () => {
	window.scrollTo(0, 0);
})


closeFilter.addEventListener('click', () => {
	filter[0].classList.toggle("active");
	bdy.classList.toggle('lock');
})

cancelFilter.addEventListener('click', () => {
	filterForm.reset();
})


filterBtn.addEventListener('click', () => {
	filter[0].classList.toggle("active");
	bdy.classList.toggle('lock');
});

// arr[0].nextElementSibling.classList.toggle('active');
// arr[0].children[1].classList.toggle('active');

for (let i=0; i<arr.length; i++){
	arr[i].addEventListener('click', () => {
		arr[i].nextElementSibling.classList.toggle('active');
		arr[i].children[1].classList.toggle('active');	
	});
}


let page = 0;

// END SCROLL PAGE


function endPage () {

	if (window.pageYOffset >= (bdy.scrollHeight - (bdy.clientHeight + 200))){

		// AJAX Request
		page++;
		let url = window.location.search ? window.location.search : '?';
		url = 'cataloghandler.php' + url + '&page=' + page;
	
		xhr = new XMLHttpRequest();
		xhr.open('GET', url, true);
		
		// console.log(url);
		xhr.onload = function () {
			if(this.status == 200){
				catalogContent.insertAdjacentHTML('beforeend', this.responseText);
			}
		}

		xhr.send();
	};

	if (window.pageYOffset >= bdy.clientHeight*2){
		upBtn.classList.add('active');
	} else upBtn.classList.remove('active');
};

window.addEventListener('scroll', endPage);




// getGetParams();