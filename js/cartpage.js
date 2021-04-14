// let cartProduct = document.querySelectorAll('.cart__product');
// let cartImg = document.querySelector('.header__cart');

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


// let bdy = document.body;
let wrapper = document.querySelector('.wrapper');
let orderConfirmBlock = document.querySelector('.order-confirm');
let orderConfirmCloseBtn = orderConfirmBlock.querySelector('img');
let form = document.clientData;

orderConfirmCloseBtn.addEventListener('click', () => {
	orderConfirmBlock.classList.remove('active');
	bdy.classList.remove('lock');
	wrapper.style.pointerEvents = '';
	}
);

function validate() {
	if((form.clientName.value != '') && (form.clientEmail != '') && (form.clientTel != '') 
		&& (form.clientAddress != '') && (form.clientEmail != '') && (form.delivery.checked) &&
		(form.payment[0].checked || form.payment[1].checked))
		return true;
	return false;

}

document.clientData.submit.addEventListener('click', () => {
			if(validate()){
				fillConfirmBlock();
				wrapper.style.pointerEvents = 'none';
				orderConfirmBlock.classList.add('active');
				bdy.classList.add('lock');
				scrollTo(top);
			}
			else alert('Заполните пожалуйста все поля формы с вашими данными для заказа');
		});



function fillConfirmBlock () {
	let customerBlock = document.querySelector('.order-confirm__customer');
	let deliveryBlock = document.querySelector('.order-confirm__delivery');
	let orderItemsBlock = document.querySelector('ol');

	let deliveryMethod = '';

	if(form.delivery.checked)
		deliveryMethod = 'курьер (бесплатно)';

	if(form.payment[0].checked){
		paymentMethod = 'при получении';
	} else paymentMethod = 'оплата онлайн';

	customerBlock.innerText = '';

	customerBlock.insertAdjacentHTML('beforeend', 
		'<p>' + form.clientName.value + '<br>' +
		form.clientAddress.value + '<br>' +
		form.clientTel.value + '<br>' +
		form.clientEmail.value + '</p>' +
		'<p>Способ доставки: ' + deliveryMethod + '<br>' +
		'Способ оплаты: ' + paymentMethod + '</p>'
		);
}