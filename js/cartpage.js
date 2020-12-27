let cartProduct = document.querySelectorAll('.cart__product');
let cartImg = document.querySelector('.header__cart');

// cartProduct.forEach((element) => {
// 	element.querySelector('.cart__price').children[1].addEventListener('touchend', () => deleteFromCart(element.id, element));
// });


// function deleteFromCart(id, element)
// {
// 	cartImg.children[1].innerText = Number(cartImg.children[1].innerText) - 1;
// 	element.remove();
// 	ajaxDeleteFromCart(id);
// }

// function ajaxDeleteFromCart(product_id){

// 		var params = 'action=delete&product_id=' + product_id;
// 		var xhr = new XMLHttpRequest();		
// 		xhr.open('POST', 'include/session.php', true);		
// 		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

// 		xhr.onload = function () {
// 			if(this.status == 200){
// 				console.log(this.responseText);
// 			}
// 		}
// 		xhr.send(params);

// }