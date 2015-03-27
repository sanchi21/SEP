
function validation()
{
    var cat = document.getElementById('category_t').value;
    var type = cat.substr(10);
    var ip_address = document.getElementsByName('ip_address_t[]');
    var purchase_date = document.getElementsByName('purchase_date_t[]');
    var warranty_exp = document.getElementsByName('warranty_exp_t[]');
    var insurance = document.getElementsByName('insurance_t[]');
    var value = document.getElementsByName('value_t[]');
    var msg = document.getElementById("msg");
    var ipFormat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    var dateFormat = /^([0-9][0-9])\/([0-9][0-9])\/([0-9]{4})$/;
    var amount  = /^\d+(?:\.\d{0,2})$/;
    var phonenoFormat = /^\d{10}$/;
    msg.innerHTML = "";



    for(var i=0 ; i<ip_address.length ; i++)
    {
        if(ip_address[i].value != "")
        {
            if(!ip_address[i].value.match(ipFormat))
            {
                msg.innerHTML = "Invalid IP Address!";
                document.getElementById("error_msg").style.display = "block";
                ip_address[i].focus();
                return false;
            }
        }
        //if(purchase_date[i].value != "")
        //{
        //    if(!purchase_date[i].value.match(dateFormat))
        //    {
        //        msg.innerHTML = "Invalid purchase date format!";
        //        document.getElementById("error_msg").style.display = "block";
        //        purchase_date[i].focus();
        //        return false;
        //    }
        //}
        //
        //if(warranty_exp[i].value != "")
        //{
        //    if(!warranty_exp[i].value.match(dateFormat))
        //    {
        //        msg.innerHTML = "Invalid warranty exp date format!";
        //        document.getElementById("error_msg").style.display = "block";
        //        warranty_exp[i].focus();
        //        return false;
        //    }
        //}

        if(insurance[i].value != "")
        {
            if(!amount.test(insurance[i].value))
            {
                msg.innerHTML = "Invalid insurance amount!";
                document.getElementById("error_msg").style.display = "block";
                insurance[i].focus();
                return false;
            }
        }

        if(value[i].value != "")
        {
            if(!amount.test(value[i].value))
            {
                msg.innerHTML = "Invalid value amount!";
                document.getElementById("error_msg").style.display = "block";
                value[i].focus();
                return false;
            }
        }

        if(type == "Dongle" || type == "Sim")
        {
            var phone_no = document.getElementsByName("phone_number_t[]");
            if(phone_no[i].value != "")
            {
                if(!phone_no[i].value.match(phonenoFormat))
                {
                    msg.innerHTML = "Invalid phone number!";
                    document.getElementById("error_msg").style.display = "block";
                    phone_no[i].focus();
                    return false;
                }
            }
        }
    }

    return true;
}

function validation2()
{
    var type = document.getElementById('type_t').value;
    var ip_address = document.getElementById('ip_address_t');
    var purchase_date = document.getElementById('purchase_date_t');
    var warranty_exp = document.getElementById('warranty_exp_t');
    var insurance = document.getElementById('insurance_t');
    var value = document.getElementById('value_t');
    var msg = document.getElementById("msg");
    var ipFormat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    var dateFormat = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    var amount  = /^\d+(?:\.\d{0,2})$/;
    var phonenoFormat = /^\d{10}$/;
    msg.innerHTML = "";



        if(ip_address.value != "")
        {
            if(!ip_address.value.match(ipFormat))
            {
                msg.innerHTML = "Invalid IP Address!";
                document.getElementById("error_msg").style.display = "block";
                ip_address.focus();
                return false;
            }
        }
        //if(purchase_date.value != "")
        //{
        //    if(!purchase_date.value.match(dateFormat))
        //    {
        //        msg.innerHTML = "Invalid purchase date format!";
        //        document.getElementById("error_msg").style.display = "block";
        //        purchase_date.focus();
        //        return false;
        //    }
        //}

        //if(warranty_exp.value != "")
        //{
        //    if(!warranty_exp.value.match(dateFormat))
        //    {
        //        msg.innerHTML = "Invalid warranty exp date format!";
        //        document.getElementById("error_msg").style.display = "block";
        //        warranty_exp.focus();
        //        return false;
        //    }
        //}

        if(insurance.value != "")
        {
            if(!amount.test(insurance.value))
            {
                msg.innerHTML = "Invalid insurance amount!";
                document.getElementById("error_msg").style.display = "block";
                insurance[i].focus();
                return false;
            }
        }

        if(value.value != "")
        {
            if(!amount.test(value.value))
            {
                msg.innerHTML = "Invalid value amount!";
                document.getElementById("error_msg").style.display = "block";
                value.focus();
                return false;
            }
        }

        if(type == "Dongle" || type == "Sim")
        {
            var phone_no = document.getElementById("phone_number_t");
            if(phone_no.value != "")
            {
                if(!phone_no.value.match(phonenoFormat))
                {
                    msg.innerHTML = "Invalid phone number!";
                    document.getElementById("error_msg").style.display = "block";
                    phone_no.focus();
                    return false;
                }
            }
        }

    return true;
}