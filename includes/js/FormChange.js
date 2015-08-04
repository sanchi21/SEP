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

//function addButton()
//{
//    //get the no of current rows (it includes the header as well)
//    var curRows = document.getElementById("hardwareTable").rows.length-1;
//
//    if(curRows < 5)
//    {
//        //find the required table id
//        var table = document.getElementById("hardwareTable");
//
//        //find the id of the table body
//        var tab = document.getElementById("tableBody")
//
//        var firstRow = document.getElementById("firstRow");
//        var clone = firstRow.cloneNode(true);
//
//        clone.deleteCell(0);
//        var t1 = document.createElement("input");
//        t1.setAttribute('class', 'form-control input-sm');
//        t1.setAttribute('style', 'width:184px');
//        t1.setAttribute('name', 'attribute_name[]');
//        clone.insertCell(0).appendChild(t1);
//
//        tab.appendChild(clone);
//    }
//}

//function removeButton()
//{
//    //get the no of current rows (it includes the header as well)
//    var curRows = document.getElementById("hardwareTable").rows.length-1;
//
//    //find the required table id
//    var table = document.getElementById("hardwareTable");
//    var count = document.getElementById("hardwareTable").rows.length;
//
//    if(count>2)
//        table.deleteRow(-1);
//}
//
//function addButton()
//{
//    //get the no of current rows (it includes the header as well)
//    var curRows = document.getElementById("hardwareTable").rows.length-1;
//
//    if(curRows < 25)
//    {
//        //find the required table id
//        var table = document.getElementById("hardwareTable");
//
//        //find the id of the table body
//        var tab = document.getElementById("tableBody")
//
//        var firstRow = document.getElementById("firstRow");
//        var clone = firstRow.cloneNode(true);
//
//        tab.appendChild(clone);
//    }
//}

function addButton(tableID)
{
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;

    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for(var i=0; i<colCount; i++)
    {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
    }
}

function removeButton(tableID)
{
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++)
    {
        var row = table.rows[i];
        var chkbox =row.querySelector('input[type=checkbox]');
        if(null != chkbox && true == chkbox.checked)
        {
            if(rowCount <= 2)
            {               // limit the user from removing all the fields
                alert("Cannot Remove item");
                break;
            }
            table.deleteRow(i);
            rowCount--;
            i--;
        }
    }
}

function selectItem(name,val)
{
    var items = document.getElementsByName(name);
    var count = 0;

    for(var i=0 ; i < items.length ; i++)
    {
        var item = items[i].value;
        if(item == 'Not Selected' || val == 'Not Selected')
            continue;

        if(item == val)
        {
            count++;
        }
    }

    if(count>1) {
        alert('Item already selected');
        $('select option[value="Not Selected"]').attr("selected",true);
    }
}

//function newVendor()
//{
//    var div = document.getElementById('vendor1'),
//     clone = div.cloneNode(true);
//    var mainTab = document.getElementById("mainTab");
//    //clode.id = "vendor3";
//    //document.getElementById('n2').innerHTML =  "kl";
//
//    var tabNo = $('.nav-tabs .active').text();
//    var newVendorID = parseInt(tabNo) + 1;
//
//    clone.setAttribute('id','vendor'.concat(newVendorID));
//    clone.setAttribute('class','tab-pane');
//
//    //var divWell = document.createElement('div');
//    //divWell.setAttribute('class','well');
//    //var divTable = document.createElement('table');
//    //divTable.setAttribute('width','100%');
//    //var divTr = document.createElement('tr');
//    //var divTd1 = document.createElement('td');
//    //var divTd2 = document.getElementById('itemCloumn'),
//    //    tdClone = divTd2.cloneNode(true);
//    //var divTd3 = document.createElement('td');
//    //var lblVendor = document.createElement('label');
//    //
//    //divTd1.setAttribute('width','15%');
//    //var addButton =  document.createElement('INPUT');
//    //addButton.setAttribute('type','button');
//    //addButton.setAttribute('value','+');
//    //addButton.setAttribute('class','btn btn-primary form-control');
//    //addButton.setAttribute('style','width: 40px; height: 40px; font-size: 18px');
//    //var t = $('.nav-tabs .active').text();
//    //alert(t);
//
//
//    var ul = document.getElementById('myTab');
//    var count = $("#tab-count ul").children().length;
//    //lblVendor.value = 'Vendor ('.count.concat(')');
//
//    var li = document.createElement('li');
//    var a = document.createElement('a');
//    var pl = document.getElementById('plus');
//
//    a.textContent = count;
//    a.setAttribute('href','#vendor'.concat(count));
//    a.setAttribute('aria-controls','vendor'.concat(count));
//    a.setAttribute('role','tab');
//    a.setAttribute('data-toggle','tab');
//
//    li.setAttribute('role','presentation');
//    li.appendChild(a);
//    ul.removeChild(pl);
//    ul.appendChild(li);
//    ul.appendChild(pl);
//
//
//    mainTab.appendChild(clone);
//    //document.body.appendChild(clone);
//}

function findSum()
{
    var noOfVendors = document.getElementById('no_of_vendors').value;
    var tax = document.getElementById('tax').value;
    var msg = document.getElementById("msg");
    var smsg = document.getElementById("smsg");

    for(var i=1 ; i<=noOfVendors ; i++)
    {
        var tableName = 'v'.concat(i);
        var tbl = document.getElementById(tableName);
        var tblRows = tbl.rows;

        for(var j=0 ; j<tbl.rows.length - 1 ; j++)
        {
            //var tblCells = tblRows[j+1].cells;
            var quantity = parseInt(tbl.rows[j+1].cells[3].children[0].value);
            var price = parseFloat(tbl.rows[j+1].cells[4].children[0].value);
            var total = quantity * price;
            var tax_total = total + (total*tax);
            var item = tbl.rows[j+1].cells[1].children[0].value;

            if(isNaN(total))
            {
                msg.innerHTML = "Please Provide Valid Input for Price! in Vendor (".concat(i).concat(")");
                document.getElementById("error_msg").style.display = "block";
                $(tbl.rows.item(j+1).cells[4]).find('input').focus();
                return false;
            }

            if(item == 'Not Selected')
            {
                msg.innerHTML = "Please Select an Item! in Vendor (".concat(i).concat(")");
                document.getElementById("error_msg").style.display = "block";
                $(tbl.rows.item(j+1).cells[1]).find('select').focus();
                return false;
            }

            $(tbl.rows.item(j+1).cells[5]).find('input').val(total);
            $(tbl.rows.item(j+1).cells[6]).find('input').val(tax_total);
        }
    }
    document.getElementById("error_msg").style.display = "none";
    smsg.innerHTML = "Request Form Verified! Click Submit to Submit the Request!";
    document.getElementById("success_msg").style.display = "block";

    return true;
    //var tbl = document.getElementById('v1');
    //var tblRows = tbl.rows;
    //var tblCells = tblRows[1].cells;
    //$(tbl.rows.item(1).cells[4]).find('input').val("45");

    //alert(tbl.rows[1].cells[3].children[0].value);
}

function verify()
{
    var vendors = document.getElementsByName('vendor_name[]');
    var noOfVendors = document.getElementById('no_of_vendors').value;
    var msg = document.getElementById("msg");

    if(noOfVendors > 1)
    {
        for (var i = 0; i < vendors.length - 1; i++)
        {
            for (var j = i + 1; j < noOfVendors; j++)
            {
                if (vendors[i].value == vendors[j].value)
                {
                    msg.innerHTML = "Duplication of Vendors ".concat((i+1)).concat(' and ').concat((j+1)).concat(" ! Please Provide Unique Vendor for Each Entry");
                    document.getElementById("error_msg").style.display = "block";
                    return false;
                }
            }
        }
    }

    for(var x=1 ; x<=noOfVendors ; x++)
    {
        var tableName = 'v'.concat(x);
        var tbl = document.getElementById(tableName);

        for(var y=1 ; y<tbl.rows.length - 2 ; y++)
        {
            var item1 = parseInt(tbl.rows[y].cells[1].children[0].value);
            for(var z=y+1 ; z < tbl.rows.length - 1 ; z++)
            {
                var item2 = parseInt(tbl.rows[z].cells[1].children[0].value);
                if(item1 == item2)
                {
                    msg.innerHTML = "Item Already Selected! Please Select Another Item : Vendor (".concat(x).concat(")");
                    document.getElementById("error_msg").style.display = "block";
                    $(tbl.rows.item(z).cells[1]).find('select').focus();
                    return false;
                }
            }
        }
    }
    document.getElementById("error_msg").style.display = "none";
    return findSum();
}
