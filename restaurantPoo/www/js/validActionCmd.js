var art;
var artQuantity = [];
var cmd;
var total;

function loadDetails() {
    //lancer une cmd Ajax
    $.getJSON("index.php","name=cmdAjax&id="+$('#product').val(),showDetails);
}

function showDetails(data) {
    $('#productDetails img').attr('src', 'www/img/' + data.photo);
    $('#productDetails p').append(data.description);
    $('#productDetails strong').append(data.prix);
    
    art = data;
}

function addBasket() {
    
    if(localStorage.getItem('commande')) {
        cmd = JSON.parse(localStorage.getItem('commande'));
    } else {
        cmd = [];
    }
    artQuantity = [art, $('#quantity').val()];

    cmd.push(artQuantity);

    localStorage.setItem('commande', JSON.stringify(cmd));
    
    displayCmd();
    
}

function displayCmd() {
    cmd = JSON.parse(localStorage.getItem('commande'));
    $('#panier').empty();
    if(cmd !== null) {
        $('#panier').append('<thead><th>Quantité</th><th>Produit</th><th>Prix</th><th>Totale</th></thead>');
        total = 0;
        for(var i = 0; i < cmd.length; i++) {
            total += cmd[i][0]['prix'] * cmd[i][1];
            $('#panier').append(`<tbody><td>${cmd[i][1]}</td><td>${cmd[i][0]['name']}</td><td>${cmd[i][0]['prix']}</td><td>${cmd[i][0]['prix'] * cmd[i][1]}</td></tbody>`);
        }
            $('#panier').append(`<tbody><td colspan=3>Panier</td><td>${total}</td></tbody>`);
    }
}

function validate() {
    //preparer une cmd ajax
    //index.php?commande=??
    //controller cmdAjax()
    var toSend = JSON.stringify(cmd);
    $.get('index.php', 'name=cmdAjax&commande='+toSend+'&total='+total, emptyOrder);
}

function emptyOrder() {
    localStorage.clear();
    displayCmd();
}

$(function() {
    $('#product').on('change', loadDetails);
    $('#add').on('click', addBasket);
    $('#order').on('click', validate);
    loadDetails();
    displayCmd();
});