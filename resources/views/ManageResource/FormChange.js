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
    var curRows = document.getElementById("hardwareTable").rows.length-1;
    var table = document.getElementById("hardwareTable");
    var tab = document.getElementById("tableBody")

    if(val<curRows)
    {
        var diff = curRows - val;
        for(var i=0 ; i < diff ; i++)
        {
            table.deleteRow(-1);
        }
    }
    else if(val>curRows)
    {
        var diff = val - curRows;
        var firstRow = document.getElementById("firstRow");
        var clone = firstRow.cloneNode(true);

        for(var i=0 ; i < diff ; i++)
        {
            var clone = firstRow.cloneNode(true);
            tab.appendChild(clone);
        }
    }
}