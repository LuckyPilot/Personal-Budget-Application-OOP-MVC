const form = document.getElementById("expenseForm");

async function fetchData() {
	try {
		let userInput = new FormData();
		userInput.append('category', form.category.value);
		userInput.append('amount', form.amount.value);
		let response = await fetch('/Menu/informAboutLimit', {method: 'POST', body: userInput});
		let data = await response.text();
		return data;
	} catch(error) {
		console.log(error);
		return "Wystąpił błąd";
	}
}

async function getData() {
	let answer = await fetchData();
	console.log(answer);
	let container = document.getElementById("ajaxLimit");
	container.innerHTML = answer;
}

let expenseCategory = form.expenseCategoryRadios;
let expenseAmount = form.amount;

expenseCategory.addEventListener("change", getData);
expenseAmount.addEventListener("change", getData);


