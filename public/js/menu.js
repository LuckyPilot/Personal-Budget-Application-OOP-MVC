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

// Event responsible for drop down menu with own dates selections windows, inside create balance button
document.getElementById("period").addEventListener(  "input", function() { 

	if (this.value == "ownPeriod") {
		document.getElementById("begDate").removeAttribute("disabled");
		document.getElementById("endDate").removeAttribute("disabled");
		$("#dataSelection").fadeIn("slow");
	} else {
		$("#dataSelection").fadeOut("slow");
		document.getElementById("begDate").setAttribute("disabled", "true");
		document.getElementById("endDate").setAttribute("disabled", "true");
	}
	
} );


// Event responsible for insertion current and maximum date in income and expense date selection field.
document.addEventListener( "DOMContentLoaded", function() {
	let currentDate = new Date();
	
	// Function create require double digit number even if number < 10
	function makeDoubleDigit( digit ) {
		if (digit < 10)
			return "0" + digit;
		else
			return digit;
	}
	
	let year = currentDate.getFullYear();
	let month = makeDoubleDigit( currentDate.getMonth() + 1 );
	let day = makeDoubleDigit( currentDate.getDate() );
	
	// Set default date as current date
	currentDate = year + "-" + month + "-" + day;
	document.getElementById("incomeDate").value = currentDate;
	document.getElementById("expenseDate").value = currentDate;

	// Finding last day of current month
	let lastDayOfCurrentMonthDate = new Date( year, month, 0 );
	let lastDay = lastDayOfCurrentMonthDate.getDate();
	
	// Set maximum date to set as last day of current month
	maxDate = year + "-" + month + "-" + lastDay;
	document.getElementById("incomeDate").max = maxDate;
	document.getElementById("expenseDate").max = maxDate;
	
} );


