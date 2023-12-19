function cofirmdetails() {
    let final_amount = document.getElementById('final_amount').value;
    if (final_amount == "" || final_amount == null) {
        alert("Final amount can not be empty !!")
        return false;
    }

    var are_you_sure = confirm("Are you sure ?");
    if (are_you_sure == true) {

        document.querySelector(
            "body").style.visibility = "hidden";
        document.querySelector(
            "#loader").style.visibility = "visible";
        document.querySelector(
            "#loader").style.zIndex = "2";

        return true;
    } else {
        return false;
    }
}