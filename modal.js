// Get the modal
var add_book = document.getElementById("add_book");
var add_reader = document.getElementById("add_reader");
var give_book = document.getElementById("give_book");

// Get the button that opens the modal
var op_add_book = document.getElementById("op_add_book");
var op_add_reader = document.getElementById("op_add_reader");
var op_give_book = document.getElementById("op_give_book");

// Get the <span> element that closes the modal
var cl_add_book = document.getElementById("cl_add_book");
var cl_add_reader = document.getElementById("cl_add_reader");
var cl_give_book = document.getElementById("cl_give_book");

// When the user clicks the button, open the modal 
op_add_book.onclick = function() {
  add_book.style.display = "block";
}
op_add_reader.onclick = function() {
  add_reader.style.display = "block";
}
op_give_book.onclick = function() {
  give_book.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
cl_add_book.onclick = function() {
  add_book.style.display = "none";
}
cl_add_reader.onclick = function() {
  add_reader.style.display = "none";
}
cl_give_book.onclick = function() {
  give_book.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
/*
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
*/