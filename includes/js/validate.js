
function validation()
{
    var column_to_validate = document.getElementById('columns_valid').value;
    var msg = document.getElementById("msg");
    var columns_with_rules = column_to_validate.split('/');
    var columns = [];
    var quantity = document.getElementById('quantity').value;
    msg.innerHTML = "";
    var validation_rule = [];

    for(var i=0 ; i < columns_with_rules.length ; i++)
    {
        var column_name = columns_with_rules[i];
        var key = column_name.substr(0, column_name.lastIndexOf('-'));
        var value = column_name.substr(column_name.lastIndexOf('-')+1);
        var name = key.concat('[]');
        columns[i] = name;
        validation_rule[i] = parseInt(value);
    }


    for(var j=0 ; j<quantity ; j++)
    {
        for(var k=0 ; k<columns.length ; k++)
        {
            if(validation_rule[k] >0 )
            {
                var temp = document.getElementsByName(columns[k]);
                var val = temp[j].value;
                var status  = validate(val,validation_rule[k]);

                if(!status)
                {
                    msg.innerHTML = getErrorMsg(validation_rule[k]);
                    document.getElementById("error_msg").style.display = "block";
                    temp[j].focus();

                    return false;
                }
            }
        }
    }
}

function validate(value,validation)
{
    var dateFormat = /^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
    var ipFormat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    var phonenoFormat = /^\d{10}$/;
    var emailFormat = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var serialFormat = /^[0-9]{2}-[0-9]{5}-[0-9]{6}$/;
    var alphaNumeric = /^[a-zA-Z0-9]*$/;
    var alphaDash = /^[a-zA-Z0-9-_]+$/;
    var screen = /^[0-9]*"$/;
    var proccesor = /^[0-9].[0-9] [a-zA-Z]{3}$/;


    if(validation == 1)
    {
        if(value == "")
            return false;
        else
            return true;
    }
    else if(validation == 2)
    {
        if(value != "") {
            if (!value.match(dateFormat))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 3)
    {
        if(value != "") {
            if (!value.match(emailFormat))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 4)
    {
        if(value != "") {
            if (isNaN(value))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 5)
    {
        if(value != '') {
            if (!value.match(ipFormat))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 6)
    {
        if(value != '') {
            var amount = +value;
            if (isNaN(amount))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 7)
    {
        if(value == "")
            return false;
        else
            return true;
    }
    else if(validation == 8)
    {
        if(value == "")
            return false;
        else
            return true;
    }
    else if(validation == 9)
    {
        if(value != "") {
            var amount = +value;

            if (value == "" || isNaN(amount))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 10)
    {
        if(value != "") {
            if (!value.match(phonenoFormat))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 11)
    {
        if(value != "") {
            if (!value.match(serialFormat))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 12)
    {
        if(value != "") {
            if (!value.match(alphaDash))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 13)
    {
        if(value != "") {
            if (!value.match(proccesor))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 14)
    {
        if(value != "") {
            if (!value.match(alphaNumeric))
                return false;
            else
                return true;
        }
        else
            return true;
    }
    else if(validation == 15)
    {
        if(value != "") {
            if (!value.match(screen))
                return false;
            else
                return true;
        }
        else
            return true;
    }
}

function getErrorMsg(num)
{
    switch (num)
    {
        case 1 : return "Field is required!" ; break;
        case 2 : return "Invalid date format! format: yyyy-mm-dd" ; break;
        case 3 : return "Invalid Email!" ; break;
        case 4 : return "Field should be an integer!" ; break;
        case 5 : return "Invalid IP Address!" ; break;
        case 6 : return "Field should be a numeric value" ; break;
        case 7 : return "Field should be a text value!" ; break;
        case 8 : return "Field is required and it should be a text!" ; break;
        case 9 : return "Field is required and it should be an integer!" ; break;
        case 10 : return "Invalid phone number!" ; break;
        case 11 : return "Invalid serial number!" ; break;
        case 12 : return "Field should be alphanumeric and may contain dashes!" ; break;
        case 13 : return "Invalid pattern! Should be of X.X AAA pattern" ; break;
        case 14 : return "Field should be alphanumeric!" ; break;
        case 15 : return "Invalid serial pattern! Should be of X\" pattern" ; break;

    }
}

function validation3()
{
    var attribute_name = document.getElementsByName('attribute_name[]');
    var existing_attribute = document.getElementsByName('existing_attribute[]');

    var msg = document.getElementById("msg");

    msg.innerHTML = "";


    for(var i=0 ; i<existing_attribute.length ; i++)
    {
        if (existing_attribute[i].value != "")
        {
            return true;
        }
    }

    if(attribute_name[0].value == "")
    {
        msg.innerHTML = "Please Set Attributes. Settings Not Saved!";
        document.getElementById("error_msg").style.display = "block";
        return false;
    }

    return true;
}