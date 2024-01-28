window.togglePassword = function(inputToggle){
    let input = inputToggle.parentElement.querySelector('input');
    inputToggle.classList.toggle('fa-eye-slash');
    inputToggle.classList.toggle('fa-eye');
    input.type = input.type === 'password' ? 'text' : 'password';
}