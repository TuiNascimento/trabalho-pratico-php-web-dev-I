function CreateAccountFormController() {

    this.init = function () {
        bindUsernameValidation();
        bindPasswordValidation();
    }

    var showValidationAlert = function(alertText){
        var errorAlertRefence = $(".js-error-alert");
        errorAlertRefence.append(alertText + '<br>');
        errorAlertRefence.show();
    }

    var bindUsernameValidation = function () {
        var submitButtonReference = $(".js-submit-button");
        submitButtonReference.click(function (e) {
            var userInputReference = $(".js-user-input");

            if(!validateUsername(userInputReference.val())) {
                e.preventDefault();
                showValidationAlert("O nome de usuário deve conter apenas letras, e conter entre 3 e 20 caracteres.");
                return false;
            }
        })
    }

    var validateUsername = function (username) {
        let usernameRegex =  /^[A-Za-z]\w{3,20}$/;;
        if (username.match(usernameRegex)) {
            return true
        }

        return false;
    }

    var bindPasswordValidation = function () {
        var submitButtonReference = $(".js-submit-button");
        submitButtonReference.click(function (e) {
            var passwordInputReference = $(".js-password-input");
            if(!validatePassword(passwordInputReference.val())) {
                e.preventDefault();
                showValidationAlert("A senha deve conter entre 7 e 15 caracteres, contendo pelo menos um número e um caractere especial.");
                return false;
            }
        })
    }

    var validatePassword = function (password) {
        let strongPasswordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
        if (password.match(strongPasswordRegex)) {
            return true
        }

        return false;
    }

}

var createAccountFormController
$(document).ready(function () {
    createAccountFormController = new CreateAccountFormController();
    createAccountFormController.init();
})