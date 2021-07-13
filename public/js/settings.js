// Events responsible for calling displayFormular function for every button in usermenu
document.getElementById("option0").addEventListener(  "click", function() { displayFormular( 0 ); } );
document.getElementById("option1").addEventListener(  "click", function() { displayFormular( 1 ); } );
document.getElementById("option2").addEventListener(  "click", function() { displayFormular( 2 ); } );
document.getElementById("option3").addEventListener(  "click", function() { displayFormular( 3 ); } );

// Function responsible for changing button's arrows and bottom corners 
function displayFormular( option ) {
	
	let button = document.getElementById("option" + option);
	let arrow = button.getElementsByTagName( "i" );
	
	if (button.getAttribute("aria-expanded") == "true") {
		button.style.borderRadius = "10px";
		arrow[0].className = "icon-down-big";
		arrow[2].className = "icon-down-big";
	} else {
		button.style.borderRadius = "10px 10px 0 0";
		arrow[0].className = "icon-up-big";
		arrow[2].className = "icon-up-big";
	}
	
}

// Event responsible for drop down menu with different formular in profile data manager
document.getElementById("profileDataManager").addEventListener(  "input", function() { 

	switch( this.value ) {
		case "changePassword":
			$("#changeName").fadeOut("slow", function() {
				$("#changeEmail").fadeOut("slow", function() {
					$("#changePassword").fadeIn("slow");
				});
			});
			break;
		case"changeEmail":
			$("#changeName").fadeOut("slow", function() {
				$("#changePassword").fadeOut("slow", function() {
					$("#changeEmail").fadeIn("slow");
				});
			});
			break;
		case "changeName":
		$("#changeEmail").fadeOut("slow", function() {
				$("#changePassword").fadeOut("slow", function() {
					$("#changeName").fadeIn("slow");
				});
			});
			break;
		default:
			$("#changeEmail").fadeOut("slow");
			$("#changePassword").fadeOut("slow");
			$("#changeName").fadeOut("slow");
	}
	
} );

// Event responsible for drop down menu with different formular in income category manager
document.getElementById("incomeCategoryManager").addEventListener(  "input", function() { 

	switch( this.value ) {
		case "add":
			$("#deleteIncomeCategory").fadeOut("slow", function() {
				$("#modifyIncomeCategory").fadeOut("slow", function() {
					$("#addNewIncomeCategory").fadeIn("slow");
				});
			});
			break;
		case"delete":
			$("#addNewIncomeCategory").fadeOut("slow", function() {
				$("#modifyIncomeCategory").fadeOut("slow", function() {
					$("#deleteIncomeCategory").fadeIn("slow");
				});
			});
			break;
		case "modify":
		$("#addNewIncomeCategory").fadeOut("slow", function() {
				$("#deleteIncomeCategory").fadeOut("slow", function() {
					$("#modifyIncomeCategory").fadeIn("slow");
				});
			});
			break;
		default:
			$("#addNewIncomeCategory").fadeOut("slow");
			$("#deleteIncomeCategory").fadeOut("slow");
			$("#modifyIncomeCategory").fadeOut("slow");
	}
	
} );

// Event responsible for drop down menu with different formular in expense category manager
document.getElementById("expenseCategoryManager").addEventListener(  "input", function() { 

	switch( this.value ) {
		case "add":
			$("#deleteExpenseCategory").fadeOut("slow", function() {
				$("#modifyExpenseCategoryName").fadeOut("slow", function() {
					$("#modifyExpenseCategoryLimit").fadeOut("slow", function() {
						$("#addNewExpenseCategory").fadeIn("slow");
					});
				});
			});
			break;
		case"delete":
			$("#addNewExpenseCategory").fadeOut("slow", function() {
				$("#modifyExpenseCategoryName").fadeOut("slow", function() {
					$("#modifyExpenseCategoryLimit").fadeOut("slow", function() {
						$("#deleteExpenseCategory").fadeIn("slow");
					});	
				});
			});
			break;
		case "modifyName":
		$("#addNewExpenseCategory").fadeOut("slow", function() {
				$("#deleteExpenseCategory").fadeOut("slow", function() {
					$("#modifyExpenseCategoryLimit").fadeOut("slow", function() {
						$("#modifyExpenseCategoryName").fadeIn("slow");
					});
				});
			});
			break;
		case "modifyLimit":
			$("#addNewExpenseCategory").fadeOut("slow", function() {
				$("#deleteExpenseCategory").fadeOut("slow", function() {
					$("#modifyExpenseCategoryName").fadeOut("slow", function() {
						$("#modifyExpenseCategoryLimit").fadeIn("slow");
					});
				});
			});
			break;
		default:
			$("#addNewExpenseCategory").fadeOut("slow");
			$("#deleteExpenseCategory").fadeOut("slow");
			$("#modifyExpenseCategoryName").fadeOut("slow");
			$("#modifyExpenseCategoryLimit").fadeOut("slow");
	}
	
} );

// Event responsible for drop down menu with different formular in payment method manager
document.getElementById("paymentMethodManager").addEventListener(  "input", function() { 

	switch( this.value ) {
		case "add":
			$("#deletePaymentMethod").fadeOut("slow", function() {
				$("#modifyPaymentMethod").fadeOut("slow", function() {
					$("#addNewPaymentMethod").fadeIn("slow");
				});
			});
			break;
		case"delete":
			$("#addNewPaymentMethod").fadeOut("slow", function() {
				$("#modifyPaymentMethod").fadeOut("slow", function() {
					$("#deletePaymentMethod").fadeIn("slow");
				});
			});
			break;
		case "modify":
		$("#addNewPaymentMethod").fadeOut("slow", function() {
				$("#deletePaymentMethod").fadeOut("slow", function() {
					$("#modifyPaymentMethod").fadeIn("slow");
				});
			});
			break;
		default:
			$("#addNewPaymentMethod").fadeOut("slow");
			$("#deletePaymentMethod").fadeOut("slow");
			$("#modifyPaymentMethod").fadeOut("slow");
	}
	
} );