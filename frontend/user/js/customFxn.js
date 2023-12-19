function setPriceAndStock(id, x) {
    var parent = document.getElementById('product' + id);
    var child = parent.children[0].children[0];

    //logic for remove the option from select
    if (selectedProducts.includes(x.value)) {
        x.value = -1;
        child = parent.children[1].children[0];
        child.value = '';

        child = parent.children[2].children[0];
        child.value = '';

        child = parent.children[3].children[0];
        child.value = '';

        child = parent.children[4].children[0];
        child.value = '';

        let curSelects = document.getElementsByName('product_id[]');
        let i = 0;
        curSelects.forEach(element => {
            selectedProducts[i] = element.value;
            i++;
        });
        $('#alertModal').modal('show')
        // alert("You can not select same product twice");
        return 0;
    }
    let curSelects = document.getElementsByName('product_id[]');
    let i = 0;
    curSelects.forEach(element => {
        selectedProducts[i] = element.value;
        i++;
    });



    var product_id = child.value, stock, price;
    let find = false;
    product_list.forEach(element => {

        if (element['data']['id'] == product_id) {
            stock = element['data']['stock'];
            price = element['data']['price'];
            child = parent.children[1].children[0];
            child.value = stock;



            child = parent.children[3].children[0];
            child.value = price;

            find = true;
        }
    }

    );
    if (!find) {
        child = parent.children[1].children[0];
        child.value = '';

        child = parent.children[2].children[0];
        child.value = '';

        child = parent.children[3].children[0];
        child.value = '';

        child = parent.children[4].children[0];
        child.value = '';
    }
}

function calcTotalPrice() {

    var price_values = document.getElementsByClassName('price_value');
    var total = 0;

    for (let index = 0; index < price_values.length; index++) {
        var element = price_values[index];

        total = parseInt(element.value == '' ? "0" : element.value) + total;
    }

    document.getElementById('total_amount').value = total;
}


function decreaseTotalPrice(amount) {



    var x = document.getElementById('total_amount');
    x.value = x.value - amount;
}

function updatePrice(id) {
    var parent = document.getElementById('product' + id);

    var child = parent.children[2].children[0];
    var amount = child.value;

    child = parent.children[3].children[0];
    var price = child.value;

    var newTotal = amount * price;

    child = parent.children[4].children[0];
    child.value = newTotal;
    calcTotalPrice();


    var gst = document.getElementById('gst').value;
    if(gst > 0){
        calcFinalAmount();
    }
}

function finalAmount() {
    document.getElementById('final_amount').style.border = "0px solid green";
    var total_amt = document.getElementById('total_amount').value;
    if (total_amt == 0) {

        document.getElementById('toast_error_message').innerText = "Total amount can not be zero.";
        return 0;
    }
    else {
        document.getElementById('toast_error_message').innerText = "";
    }


    var gst = document.getElementById('gst').value;
    if (gst == null) {

        document.getElementById('toast_error_message').innerText = "Please add GST Details";

        return 0;
    }
    else {
        document.getElementById('toast_error_message').innerText = "";
    }

    var discount = document.getElementById('discount').value;

    // do not update before thinking
    var gst_amount = (total_amt * gst) / 100;
    var discount_amount = (total_amt * discount) / 100;

    // must think before updating the line
    total_amt = total_amt - discount_amount + gst_amount;
    total_amt = Math.round(total_amt);

    document.getElementById('final_amount').value = total_amt;
    document.getElementById('final_amount').style.border = "1px solid green";
}

function calcFinalAmount() {
    var total_amt = document.getElementById('total_amount').value;
    if (total_amt == 0) {

        document.getElementById('toast_error_message').innerText = "Total amount can not be zero.";

        return 0;
    }
    else {
        document.getElementById('toast_error_message').innerText = "";
    }

    var gst = document.getElementById('gst').value;

    var discount = document.getElementById('discount').value;
        
    discount=discount?discount:0;
    
    // think before updating
    var gst_amount = (total_amt * gst) / 100;
    var discount_amount = (total_amt * discount) / 100;

    // must think before updating the line
    total_amt = total_amt - discount_amount + gst_amount;
    total_amt = Math.round(total_amt);
    document.getElementById('final_amount').value = total_amt;
}

function saveAsDraft() {
    let sure = confirm("You want save as draft ?")
    if (sure) {
        document.getElementById('order_status').value = 0;
        document.getElementById('new_sales_order_form').submit();
    }
}
