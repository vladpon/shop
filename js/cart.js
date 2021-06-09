let cartAmountSpan = document.querySelector('.header__cart-btn').children[1];
let addToCartBtns = document.querySelectorAll('.add-to-cart');
let cartItem = document.querySelectorAll('.cart__product')

let cart;
getCart();
refreshAmountSpan();


function redrawHeaderAmountSpan(){
	cartAmountSpan.innerText = cart.totalQuantity;
	refreshAmountSpan();
}

function redrawTotalPrice(){
	document.querySelector('.cart__total').children[0].innerText = cart.totalSum;
}

function redrawProductAmountSpan(productId){
}



function getCart(	func = function (){},
					func2 = function (){},
					func3 = function (){}){
	var params = 'action=getCart';
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'include/carthandler.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.responseType = 'json';

	xhr.onload = function () {
		if(this.status == 200){	
			cart = this.response;
			func();
			func2();
			func3();
		}
	}
	xhr.send(params);
}


function refreshAmountSpan () {
	if(Number(cartAmountSpan.innerText)){
		cartAmountSpan.style.display = 'block';
	} else cartAmountSpan.style.display = 'none';
}

function addToCart (element) {
		let product_id = element.dataset.productId;

		//Ajax Req		

		if(element.classList.contains('white'))
			return;

		let params = new FormData();
		if(document.forms.sizeselect){
			var size = document.forms.sizeselect.sel.value;
			if(size == 'Выбрать размер'){
				alert('Выберите, пожалуйста размер изделия');	
				return;		
			}
			params.append('size', size);
		}

		element.classList.add('white');
		element.value = 'ПЕРЕЙТИ В КОРЗИНУ';
		element.addEventListener('click', function(){
			document.location.href = "cartpage.php";
		})

		params.append('action', 'add');
		params.append('product_id', product_id);


		var xhr = new XMLHttpRequest();
		
		xhr.open('POST', '../include/carthandler.php', true);

		xhr.onload = function () {
			if(this.status == 200){
				getCart(redrawHeaderAmountSpan);
			}
		}
		xhr.send(params);
		
};


function deleteFromCart(item) {
	result = confirm('Вы действительно хотите удалить товар из корзины?');
	if(!result)
		return;

	var params = 'action=delete&product_id=' + item.dataset.productId + '&size=' + item.dataset.size;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'include/carthandler.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.responseType = 'json';
	xhr.onload = function () {
		if(this.status == 200){
			cart = xhr.response;
			item.remove();
			redrawHeaderAmountSpan();
			redrawTotalPrice();

			if(cart.totalQuantity == 0){
				let strEmptyCart = '<div class="cart__empty"><i>Корзина пуста...</i></div>';
				document.querySelector(".cart__product-container").insertAdjacentHTML('beforeend', strEmptyCart);
				document.querySelector('.cart__form').remove();
				document.querySelector('.cart__total').remove();					
			}		
		}
	}
	xhr.send(params);
}

function increaseQuantity (itemCount, item) {

		//Ajax Req		

		let params = new FormData();
		let size = item.dataset.size;
		let productId = item.dataset.productId;
		params.append('action', 'add');
		params.append('product_id', productId);
		params.append('size', size);

		var xhr = new XMLHttpRequest();
		
		xhr.open('POST', '../include/carthandler.php', true);
		xhr.responseType = 'json';

		xhr.onload = function () {
			if(this.status == 200){
				cart = xhr.response;
				itemCount.children[1].innerText = Number(itemCount.children[1].innerText) + 1;
				redrawHeaderAmountSpan();
				redrawTotalPrice();
			}
		}
		xhr.send(params);
}

function decreaseQuantity (itemCount, item) {
	if(Number(itemCount.children[1].innerText) > 1){
		var params = new FormData();
		params.append('action', 'decrease');
		params.append('product_id', item.dataset.productId);
		params.append('size', item.dataset.size);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'include/carthandler.php', true);
		// xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.responseType = 'json';

		xhr.onload = function () {
			if(this.status == 200){	
				cart = xhr.response;
				itemCount.children[1].innerText = Number(itemCount.children[1].innerText) - 1;
				redrawHeaderAmountSpan();
				redrawTotalPrice();
			}
		}
		xhr.send(params);
	} else {
		deleteFromCart(item);
	}

}


addToCartBtns.forEach(function(element) {
		element.addEventListener('click', () => addToCart(element));
});

for (var i = cartItem.length - 1; i >= 0; i--) {
	let item = cartItem[i];
	let cartCount = cartItem[i].querySelector('.cart__count');
	cartItem[i].querySelector('.delete-from-cart').addEventListener('click', ()=> deleteFromCart(item));
	cartCount.children[0].addEventListener('click', () => decreaseQuantity(cartCount, item));
	cartCount.children[2].addEventListener('click', () => increaseQuantity(cartCount, item));
}

// function showAmount(cartItem){
// 	product_id = cartItem.id;
// 	var params = 'action=getAmount&product_id=' + product_id;
// 	var xhr = new XMLHttpRequest();
// 	xhr.open('POST', 'include/session.php', true);
// 	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

// 	xhr.onload = function () {
// 		if(this.status == 200){	
// 			let answer = JSON.parse(this.responseText);
// 			let cartCount = cartItem.querySelector('.cart__count');
// 			cartCount.children[1].innerText = answer.amount;
// 			if(answer.amount == 0){
// 				deleteFromCart(product_id);				
// 			}
// 		}
// 	}
// 	xhr.send(params);
// }



// for (var i = addToCartBtns.length - 1; i >= 0; i--) {
// 	let productId = addToCartBtns[i].dataset.productId;
// 	addToCartBtns[i].addEventListener('click', ()=> {
// 		this.classList.add('white');	
// 		addToCart(productId);
// 	});
// }

// function addToCartBtnHandler () {
// 	let productId = addToCartBtns[0].dataset.productId;
// 	addToCart(productId);
// 	addToCartBtns[0].classList.add('white');
// 	addToCartBtns[0].value = 'ПЕРЕЙТИ В КОРЗИНУ';
// }

// addToCartBtns.forEach(function(element) {

// 		element.addEventListener('click', function() {
// 		let productId = element.dataset.productId;
// 		addToCart(productId);

// 		element.classList.add('white');
// 		element.value = 'ПЕРЕЙТИ В КОРЗИНУ';
// 		element.addEventListener('click', function(){
// 			document.location.href = "cartpage.php";
// 		})
// 	}
// 	, {once: true});
// });






// if(window.isCartPage){
// 	getTotalPrice();
// }







// function deleteFromCart(product_id)
// {
// 	result = confirm('Вы действительно хотите удалить товар из корзины?');
// 	if(!result)
// 		return;
// 	var params = 'action=delete&product_id=' + product_id;
// 	var xhr = new XMLHttpRequest();
// 	xhr.open('POST', 'include/session.php', true);
// 	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

// 	xhr.onload = function () {
// 		if(this.status == 200){	
// 			let answer = JSON.parse(this.responseText);
// 			cartAmountSpan.innerText = answer.amount;
// 			document.getElementById(product_id).remove();
// 			setTotalPrice(answer.totalPrice);
// 			// setTotality(answer.totalPrice);
			
// 			if(answer.amount == 0){
// 				let strEmptyCart = '<div class="cart__empty"><i>Корзина пуста...</i></div>';
// 				document.querySelector(".cart__product-container").insertAdjacentHTML('beforeend', strEmptyCart);
// 				document.querySelector('.cart__form').remove();
// 				document.querySelector('.cart__total').remove();					
// 			}
// 		refreshAmountSpan();
// 		}
// 	}
// 	xhr.send(params);
// }

// function getTotalPrice(){
// 	var params = 'action=getTotalPrice';
// 	var xhr = new XMLHttpRequest();
// 	xhr.open('POST', 'include/session.php', true);
// 	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
// 	let totalPrice;

// 	xhr.onload = function () {
// 		if(this.status == 200){	
// 			let answer = JSON.parse(this.responseText);
// 			totalPrice = answer.totalPrice;
// 			setTotalPrice(totalPrice);
// 			// setTotality(totalPrice);
// 		}
// 	}
// 	xhr.send(params);
// }


// function setTotalPrice(totalPrice){
// 	if(totalPrice){
// 		document.querySelector('.cart__total').children[0].innerText = totalPrice;
// 	}
// }

// function setTotality(totalPrice, deliveryCost = 300){
// 	if(totalPrice){
// 		let totality = totalPrice + deliveryCost;
// 		document.querySelector('.cart__totality').children[0].innerText = totality;
		
// 	}
// }

