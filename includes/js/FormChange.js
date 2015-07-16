/**
 * Created by sanchi on 3/12/2015.
 */

function changeAttributes()
{
    alert('sadas');
    var opt = document.getElementById("make").value;
    var table = document.getElementById("hardwareTable");
    var headingRow = document.getElementById("headRow");

    if(opt == "Monitor")
    {
        var theader = table.createTHead();
        var cell = headingRow.insertCell(-1);
        headingRow.innerHTML = "<b>Screen Size</b>";
    }
}

function addRows(val)
{
    //get the no of current rows (it includes the header as well)
    var curRows = document.getElementById("hardwareTable").rows.length-1;

    //find the required table id
    var table = document.getElementById("hardwareTable");

    //find the id of the table body
    var tab = document.getElementById("tableBody")


    if(val<curRows && val>0 && val<=10)
    {
        var diff = curRows - val;
        for(var i=0 ; i < diff ; i++)
        {
            table.deleteRow(-1);
        }
    }
    else if(val>curRows && val>0)
    {
        var diff = val - curRows;
        var firstRow = document.getElementById("firstRow");

        var inv = document.getElementById("inventory_code_t").value;
        var invStart = inv.substring(0,8);

        for(var i=0 ; i < diff ; i++)
        {
            var clone = firstRow.cloneNode(true);
            var invEnd = Number(inv.substring(8));
            if(diff!=1)
                invEnd = invEnd + 1 + i;
            else
                invEnd = invEnd + Number(val) - 1;

            var newInvEnd = invEnd.toString();
            var newCode = invStart.concat(newInvEnd);

            if(newInvEnd.length == 1)
                newCode = invStart.concat("000").concat(newInvEnd);
            else if(newInvEnd.length == 2)
                newCode = invStart.concat("00").concat(newInvEnd);
            else if(newInvEnd.length == 3)
                newCode = invStart.concat("0").concat(newInvEnd);

            clone.deleteCell(0);
            var t1=document.createElement("input");
            t1.setAttribute('class','form-control input-sm');
            t1.setAttribute('readOnly','true');
            t1.setAttribute('style','width:130px');
            t1.setAttribute('name','inventory_code[]');
            t1.setAttribute('value',newCode);
            clone.insertCell(0).appendChild(t1);
            tab.appendChild(clone);
        }

    }
}

function addButton()
{
    //get the no of current rows (it includes the header as well)
    var curRows = document.getElementById("hardwareTable").rows.length-1;

    if(curRows < 5)
    {
        //find the required table id
        var table = document.getElementById("hardwareTable");

        //find the id of the table body
        var tab = document.getElementById("tableBody")

        var firstRow = document.getElementById("firstRow");
        var clone = firstRow.cloneNode(true);

        clone.deleteCell(0);
        var t1 = document.createElement("input");
        t1.setAttribute('class', 'form-control input-sm');
        t1.setAttribute('style', 'width:184px');
        t1.setAttribute('name', 'attribute_name[]');
        clone.insertCell(0).appendChild(t1);

        tab.appendChild(clone);
    }
}

function removeButton()
{
    //get the no of current rows (it includes the header as well)
    var curRows = document.getElementById("hardwareTable").rows.length-1;

    //find the required table id
    var table = document.getElementById("hardwareTable");
    var count = document.getElementById("hardwareTable").rows.length;

    if(count>2)
        table.deleteRow(-1);
}