$(document).ready(function (){    
        //Build an array containing Customer records.
        
        fetch('/bus/')
        .then((response) => response.json())
        .then((data) => {
            var veiculos = data;            
            
            //Create a HTML Table element.
            var table = $("<table />");
            table[0].border = "1";
    
            //Get the count of columns.
            var columnCount = veiculos[0].length;
            //Add the header row.
            var row = $(table[0].insertRow(-1));
            for (var i = 0; i < columnCount; i++) {
                var headerCell = $("<th />");
                headerCell.html(veiculos[0][i]);
                row.append(headerCell);
            }
    
            //Add the data rows.
            for (var i = 1; i < veiculos.length; i++) {
                row = $(table[0].insertRow(-1));
                for (var j = 0; j < columnCount; j++) {
                    var cell = $("<td />");
                    cell.html(veiculos[i][j]);
                    row.append(cell);
                }
            }
    
            var dvTable = $("#resultado");
            dvTable.html("");
            dvTable.append(table);
        });
 
       
})