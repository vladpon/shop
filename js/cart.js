let cartAmountSpan = document.querySelector('.header__cart-btn').children[1];
let addToCartBtns = document.querySelectorAll('.add-to-cart');
let cartItem = document.querySelectorAll('.cart__product')


refreshAmountSpan();

function refreshAmountSpan () {
	if (Number(cartAmountSpan.innerText)){
		cartAmountSpan.style.display = 'block';
	} else cartAmountSpan.style.display = 'none';
}

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

addToCartBtns[0].addEventListener('click', function() {
		let productId = addToCartBtns[0].dataset.productId;
		addToCart(productId);
		addToCartBtns[0].classList.add('white');
		addToCartBtns[0].value = 'ПЕРЕЙТИ В КОРЗИНУ';
		addToCartBtns[0].addEventListener('click', function(){
			document.location.href = "cartpage.php";
		})
	}
	, {once: true});


for (var i = cartItem.length - 1; i >= 0; i--) {
	showAmount(cartItem[i]);
	let productId = cartItem[i].id;
	let cartCount = cartItem[i].querySelector('.cart__count');
	cartItem[i].querySelector('.delete-from-cart').addEventListener('click', ()=> deleteFromCart(productId));	
	cartCount.children[0].addEventListener('click', () => decreaseQuantity(cartCount.children[1], productId));
	cartCount.children[2].addEventListener('click', () => increaseQuantity(cartCount.children[1], productId));
}

if(window.isCartPage){
	getTotalPrice();
}

function showAmount(cartItem){
	product_id = cartItem.id;
	var params = 'action=getAmount&product_id=' + product_id;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'include/session.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function () {
		if(this.status == 200){	
			let answer = JSON.parse(this.responseText);
			let cartCount = cartItem.querySelector('.cart__count');
			cartCount.children[1].innerText = answer.amount;
			if(answer.amount == 0){
				deleteFromCart(product_id);				
			}
		}
	}
	xhr.send(params);
}


function addToCart (product_id) {

		//Ajax Req

		var params = 'action=add&product_id=' + product_id;
		var xhr = new XMLHttpRequest();		
		xhr.open('POST', '../include/session.php', true);		
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		xhr.onload = function () {
			if(this.status == 200){

		//analyze ajax answer
				
		//if ok cartSpanAmount++

				cartAmountSpan.innerText = Number(cartAmountSpan.innerText) + 1;
				refreshAmountSpan();

		//if not OK alert
			}
		}
		xhr.send(params);
};



function deleteFromCart(product_id)
{

	var params = 'action=delete&product_id=' + product_id;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'include/session.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function () {
		if(this.status == 200){	
			let answer = JSON.parse(this.responseText);
			cartAmountSpan.innerText = answer.amount;
			document.getElementById(product_id).remove();
			setTotalPrice(answer.totalPrice);
			setTotality(answer.totalPrice);
			
			if(answer.amount == 0){
				let strEmptyCart = '<div class="cart__empty"><i>Корзина пуста...</i></div>';
				document.querySelector(".cart__product-container").insertAdjacentHTML('beforeend', strEmptyCart);
				document.querySelector('.cart__form').remove();
				document.querySelector('.cart__total').remove();					
			}
		refreshAmountSpan();
		}
	}
	xhr.send(params);
}

function getTotalPrice(){
	var params = 'action=getTotalPrice';
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'include/session.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let totalPrice;

	xhr.onload = function () {
		if(this.status == 200){	
			let answer = JSON.parse(this.responseText);
			totalPrice = answer.totalPrice;
			setTotalPrice(totalPrice);
			setTotality(totalPrice);
		}
	}
	xhr.send(params);
}


function setTotalPrice(totalPrice){
	if(totalPrice){
		document.querySelector('.cart__total').children[0].innerText = totalPrice;
	}
}

function setTotality(totalPrice, deliveryCost = 300){
	if(totalPrice){
		let totality = totalPrice + deliveryCost;
		document.querySelector('.cart__totality').children[0].innerText = totality;
		
	}
}

function increaseQuantity (amountSpan, product_id) {
	addToCart(product_id);
	amountSpan.innerText = Number(amountSpan.innerText) + 1;
	setTotalPrice(getTotalPrice());
	refreshAmountSpan();	
}

function decreaseQuantity (amountSpan, product_id) {
	if(Number(amountSpan.innerText) > 1){
		var params = 'action=decrease&product_id=' + product_id;
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'include/session.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		xhr.onload = function () {
			if(this.status == 200){	
				setTotalPrice(getTotalPrice());
				amountSpan.innerText = Number(amountSpan.innerText) - 1;
				cartAmountSpan.innerText = Number(cartAmountSpan.innerText) - 1;
				refreshAmountSpan();	
			}
		}
		xhr.send(params);
	}
}
