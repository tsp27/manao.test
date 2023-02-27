function showInputError(input, error) {
    input.innerHTML = error;
    input.classList.remove('reg-form__error_hidden');
}

function hideInputError(input) {
    input.classList.add('reg-form__error_hidden');
}

// Registration
const regForm = document.querySelector('.reg-form');

if (regForm) {
    const loginInput = regForm.querySelector('.reg-form__login');
    const passInput = regForm.querySelector('.reg-form__pass');
    const confirmPassInput = regForm.querySelector('.reg-form__confirm-pass');
    const emailInput = regForm.querySelector('.reg-form__email');
    const nameInput = regForm.querySelector('input[name=name]');
    const regButton = regForm.querySelector('input[type=button]');

    const loginError = loginInput.nextElementSibling;
    const passError = passInput.nextElementSibling;
    const confirmPassError = confirmPassInput.nextElementSibling;
    const emailError = emailInput.nextElementSibling;
    const nameError = nameInput.nextElementSibling;

    // check login input for validity
    function checkLogin() {
        const loginValue = loginInput.value;
        const loginLength = loginValue.length;

        const regExp = /[\s]/;
        const checkLogin = regExp.test(loginValue); // check spaces

        if (loginLength < 6) {
            showInputError(loginError, 'Минимум 6 символов');
            return false;
        }
        else if (loginLength >= 6 && checkLogin) {
            showInputError(loginError, 'Не должно быть пробелов');
            return false;
        }

        loginError.classList.add('reg-form__error_hidden');
        return true;
    }

    // check password input for validity
    function checkPass() {
        const passValue = passInput.value;
        const passLength = passValue.length;
    
        const regExp = /^(?=.*[A-Za-zА-Яа-я])(?=.*\d)[A-Za-zА-Яа-я\d]{6,}$/i;
        const checkPass = regExp.test(passValue);

        if (passLength < 6) {
            showInputError(passError, 'Минимум 6 символов');
            return false;
        }
        else if (passLength >= 6 && !checkPass) {
            showInputError(passError, 'Пароль должен состоять из букв и цифр');
            return false;
        }

        passError.classList.add('reg-form__error_hidden');
        confirmPassInput.removeAttribute('disabled');
        return true;
    }

    // check confirm password input for validity
    function checkConfirmPass() {
        const passValue = passInput.value;
        const confirmPassValue = confirmPassInput.value;
        const confirmPassLength = confirmPassValue.length;
        
        if (confirmPassLength < 6) {
            showInputError(confirmPassError, 'Минимум 6 символов');
            return false;
        }
        else if (confirmPassLength >= 6 && passValue !== confirmPassValue) {
            showInputError(confirmPassError, 'Пароли не совпадают');
            return false;
        }

        confirmPassError.classList.add('reg-form__error_hidden');
        return true; 
    }

    // check email input for validity
    function checkEmail() {
        const emailValue = emailInput.value;
                
        const regExp = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9-]+.+.[A-Za-z]{2,4}$/i;
        const checkEmail = regExp.test(emailValue);
                
        if (!checkEmail) {
            showInputError(emailError, 'Введите Email');
            return false;
        }
    
        emailError.classList.add('reg-form__error_hidden');
        return true; 
    }

    // check name input for validity
    function checkName() {
        const nameValue = nameInput.value;
        const nameLength = nameValue.length;

        const regExp = /^[A-Za-zА-Яа-яЁё]{2,}$/i;
        const checkNameValue = regExp.test(nameValue);

        if (nameLength < 2) {
            showInputError(nameError, 'Минимум 2 буквы');
            return false;
        }
        else if (nameLength >= 2 && !checkNameValue) {
            showInputError(nameError, 'Вводите только буквы');
            return false;
        }
       
        nameError.classList.add('reg-form__error_hidden');
        return true; 
    }

    // check input fields when changing it
    loginInput.addEventListener('input', checkLogin);
    passInput.addEventListener('input', checkPass);
    confirmPassInput.addEventListener('input', checkConfirmPass)
    emailInput.addEventListener('input', checkEmail)
    nameInput.addEventListener('input', checkName);


    // check registration form for validity
    function checkForm() {
        const loginVal = loginInput.value;
        const passVal = passInput.value;
        const confirmPassVal = confirmPassInput.value;
        const emailVal = emailInput.value;
        const nameVal = nameInput.value;
                
        if (checkLogin()) {
            checkPass();
        }

        if (checkLogin() && checkPass()) {
            checkConfirmPass();
        }
        
        if (checkLogin() && checkPass() && checkConfirmPass()) {
            checkEmail();
        }

        if (checkLogin() && checkPass() && checkConfirmPass() && checkEmail()) {
            checkName();
        }

        if (checkLogin() && checkPass() && checkConfirmPass() && checkEmail() && checkName()) {       
            //console.log('OK');

            let user = {
                login: loginVal,
                pass: passVal,
                confirmPass: confirmPassVal,
                email: emailVal,
                name: nameVal,
                reg: regButton.value,
            };

            fetch('./action/registration.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'x-my-custom-header': 'ajax',
                },
                body: JSON.stringify(user),
            })
            .then((res)=> {
                if(res.ok) {
                    return res.json();
                }
                console.log('Error');
            })
            .then((res)=> {
                //console.log(res.status);
                if (res.status == 'success') {
                    regForm.submit();
                    location.reload();
                }
                
                //console.log(res.errors);
                if (res.errors.login) {
                    showInputError(loginError, res.errors.login)
                }
                else {
                    hideInputError(loginError);
                }

                if (res.errors.pass) {
                    showInputError(passError, res.errors.pass)
                }
                else {
                    hideInputError(passError);
                }

                if (res.errors.confirmPass) {
                    showInputError(confirmPassError, res.errors.confirmPass)
                }
                else {
                    hideInputError(confirmPassError);
                }

                if (res.errors.email) {
                    showInputError(emailError, res.errors.email)
                }
                else {
                    hideInputError(emailError);
                }

                if (res.errors.name) {
                    showInputError(nameError, res.errors.name)
                }
                else {
                    hideInputError(nameError);
                }
            });

        }
    }

    regButton.addEventListener('click', checkForm);
}
// EOF Registration


// Login
const authForm = document.querySelector('.auth-form');

if (authForm) {
    const authButton = authForm.querySelector('.auth-form__button');
    
    authButton.addEventListener('click', function() {
        const authLogin = authForm.querySelector('.auth-form__name');
        const authPass = authForm.querySelector('.auth-form__pass');

        const loginVal = authLogin.value;
        const passVal = authPass.value;
    
        const user = {
            login: loginVal,
            pass: passVal,
            button: authButton.value,
        };
    
        fetch('./action/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
            },
            body: JSON.stringify(user),
        })
        .then((res)=> {
            if(res.ok) {
                return res.json();
            }
            console.log('Error');
        })
        .then((res)=> {
            // if OK
            if (res.status == 1) {
                authForm.submit();
                location.reload();
            }
            // if errors then show it
            if (res.errors.login) {
                authLogin.nextElementSibling.innerHTML = res.errors.login;
                authLogin.nextElementSibling.classList.remove('auth-form__error_hidden');
            }
            else {
                authLogin.nextElementSibling.classList.add('auth-form__error_hidden');
            }          
            if (res.errors.pass) {
                authPass.nextElementSibling.innerHTML = res.errors.pass;
                authPass.nextElementSibling.classList.remove('auth-form__error_hidden');
            }
            else {
                authPass.nextElementSibling.classList.add('auth-form__error_hidden');
            }
        })
    });
}
// EOF Login


// Logout
const logoutButton = document.querySelector('.logout');

if (logoutButton) {
    logoutButton.addEventListener('click', function() {
        //document.cookie = "login=;max-age=-1"; // or with php in logout.php
        
        const user = {
            logout: true,
        };
        
        fetch('./action/logout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
            },
            body: JSON.stringify(user),
        })
        
        //fetch('./action/logout.php')
        .then((res)=> {
            if(res.ok) {
                return res.json();
            }
            console.log('Error');
        })
        .then(function(res) {
            // if ok reload and login in php file
            if (res.status == 1) {
                location.reload();
            }
        })
    })
}
// EOF Logout
