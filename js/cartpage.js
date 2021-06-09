

// let bdy = document.body;
let wrapper = document.querySelector('.wrapper');
let orderConfirmBlock = document.querySelector('.order-confirm');
let orderConfirmCloseBtn = orderConfirmBlock.querySelector('img');
let orderConfirmSubmitBtn = orderConfirmBlock.querySelector('.big-button');
let form = document.clientData;


orderConfirmSubmitBtn.addEventListener('click', () => confirmOrder());

if(form)
{
	document.clientData.submit.addEventListener('click', () => {
				if(validate()){
					getCart(fillConfirmBlock);
					wrapper.style.pointerEvents = 'none';
					orderConfirmBlock.classList.add('active');
					bdy.classList.add('lock');
					scrollTo(top);
				}
				else alert('Заполните пожалуйста все поля формы с вашими данными для заказа');
			});
}

orderConfirmCloseBtn.addEventListener('click', () => {
	orderConfirmBlock.classList.remove('active');
	bdy.classList.remove('lock');
	wrapper.style.pointerEvents = '';
	}
);



function validate() {
	if((form.clientName.value != '') && (form.clientEmail != '') && (form.clientTel != '') 
		&& (form.clientAddress != '') && (form.clientEmail != '') && (form.delivery.checked) &&
		form.payment.checked && form.agreement.checked
		// (form.payment[0].checked || form.payment[1].checked)
		)
		return true;
	return false;

}

function fillConfirmBlock () {
	let customerBlock = document.querySelector('.order-confirm__customer');
	let deliveryBlock = document.querySelector('.order-confirm__delivery');
	let orderItemsBlock = orderConfirmBlock.querySelector('ol');
	let orderConfirmTotal = orderConfirmBlock.querySelector('.order-confirm__total');

	customerBlock.innerText = '';
	deliveryBlock.innerText = '';
	orderItemsBlock.innerText = '';
	orderConfirmTotal.innerText = '';

	let deliveryMethod = '';

	if(form.delivery.checked)
		deliveryMethod = 'курьер (бесплатно)';

	// if(form.payment[1].checked){
	// 	orderConfirmSubmitBtn.innerText = 'ОПЛАТИТЬ';
	// 	paymentMethod = 'оплата онлайн';
	// } else {
		orderConfirmSubmitBtn.innerText = 'ПОДТВЕРДИТЬ';
		paymentMethod = 'при получении';
	// }	

	customerBlock.insertAdjacentHTML('beforeend', 
		'<p>' + form.clientName.value + '<br>' +
		form.clientAddress.value + '<br>' +
		form.clientTel.value + '<br>' +
		form.clientEmail.value + '</p>' +
		'<p>Способ доставки: ' + deliveryMethod + '<br>' +
		'Способ оплаты: ' + paymentMethod + '</p>'
		);

	 

	 for(i in cart){
	 	// if(i == 'totalQuantity' || i == 'totalSum') break; //костыль xD
	 	if(isNaN(i)) break;
		orderItemsBlock.insertAdjacentHTML('beforeend',
			'<li><div><span>' + cart[i].product.productName + ' ' +
			cart[i].product.vendorCode + ' </span>' +
			'<span>'+ cart[i].quantity + '</span>' +
			'<span> ' + cart[i].product.price + 
			' </span></div></li>'
		)
	}
	


	orderConfirmTotal.insertAdjacentHTML('beforeend', 'Итого: ' + cart.totalSum);

	
}


function confirmOrder (){
	orderConfirmSubmitBtn.style.pointerEvents = 'none';
	let clientData = new FormData(form);
	clientData.append('payment', 'cash');		//!
	clientData.append('delivery', 'courier');	//!
	clientData.append('action', 'confirmOrder');
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'include/carthandler.php');
	xhr.send(clientData);
	xhr.responseType = 'json';
	xhr.onload = () => {
			let answer = xhr.response;
			console.log(answer);
			if (answer.confirm == 'success'){
				document.location.href = 'confirmorder.php';
			}
		};
}
