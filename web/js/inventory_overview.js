function PrintElem(elem, h)
    {
        Popup($(elem).html(), h);
    }

    function Popup(data, h) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');

        mywindow.document.write('<link rel="stylesheet" href="/padi_inventory/web/assets/e2a85ad5/css/bootstrap.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="/padi_inventory/web/css/site.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + h + '</h1>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }