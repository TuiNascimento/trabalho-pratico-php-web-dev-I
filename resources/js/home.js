function getEditItemTemplate(itemId, currentName, currentQuantity) {
    return '<form action="/trabalho-pratico-php-web-dev-I/public/home.php" method="post">\n' +
        '                <input type="hidden" name="action" value="EDIT_ITEM">\n' +
        '                <input type="hidden" name="item_id" value="' + itemId + '">\n' +
        '                <div class="item rounded">\n' +
        '                    <div class="item-title">\n' +
        '                        <h4>Nome: <input type="text" class="js-name-input bg-transparent transparent-input" name="item_name" value="' + currentName + '"><br></h4>\n' +
        '                    </div>\n' +
        '                    <div class="item-quantity">\n' +
        '                        <p>Quantidade: <input type="number" class="bg-transparent transparent-input" name="item_quantity" value="' + currentQuantity + '"></p>\n' +
        '                    </div>\n' +
        '                    <div class="add-button">\n' +
        '                        <button class="btn btn-success"><i class="fa fa-check"></i> | Confirmar</button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </form>'
}

function editItem(itemReference) {
    let currentName = itemReference.find(".js-item-name").val();
    let currentQuantity = itemReference.find(".js-item-quantity").val();
    let itemId = itemReference.find(".js-item-id").val();

    let editCard = getEditItemTemplate(itemId, currentName, currentQuantity);
    itemReference.replaceWith(editCard);
    $(".js-name-input").focus();
}

function bindEditItem() {
    $(".js-edit-button").click(function (event) {
        event.preventDefault();
        editItem($(event.target.closest("div.item")));
    })
}

function bindInfoAlertFadeOut() {
    $(".js-info-alert").fadeOut(3500, "swing");
}

function bindErrorAlertCloseButton() {
    let closeAlertButtonReference = $(".js-close-alert-button");

    closeAlertButtonReference.click(function (event) {
        event.preventDefault();
        $(".js-error-alert").remove();
    })
}

function bindAlertActions() {
    bindInfoAlertFadeOut();
    bindErrorAlertCloseButton();
}

$(document).ready(function () {
    bindEditItem();
    bindAlertActions();
})