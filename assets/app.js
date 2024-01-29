import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

window.togglePassword = function(inputToggle){
    let input = inputToggle.parentElement.querySelector('input');
    inputToggle.classList.toggle('fa-eye-slash');
    inputToggle.classList.toggle('fa-eye');
    input.type = input.type === 'password' ? 'text' : 'password';
}
